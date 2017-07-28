<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GH extends Model
{
    //

    protected $fillable = [
      'user_id', 'transaction_code',
      'user_information',
      'amount', 'pending_amount',
      'lock_gh', 'ip_address', 'status', 'old_id', 'is_freeze',
  ];
  protected $table = 'tb_gh';

  public function user() {
    return $this->belongsTo('\App\User', 'user_id');
  }

  protected $searchColumns = [
      'all' => 'All',
      'tb_gh.transaction_code' => 'Code',
      'users.username' => 'Member',
      'tb_gh.amount' => 'Amount',
      'tb_gh.status' => 'Status',
  ];

  public function getSearchColumns() {
    return $this->searchColumns;
  }

  public static function myPendingGH($user_id = 0) {
    if ($user_id == 0) {
      $user_id = Auth::user()->id;
    }
    $whereArray = [
        ['user_id', '=', $user_id],
        ['pending_amount', '>', 0],
        ['is_freeze', '=', 0],
    ];
    return self::where($whereArray)->get();
  }

  public function getAdminList($params) {
    $searchField = isset($params['search_field']) ? trim($params['search_field']) : '';
    $searchText = isset($params['search_text']) ? trim($params['search_text']) : '';
    $from_date = isset($params['from_date']) ? trim($params['from_date']) : '';
    $to_date = isset($params['to_date']) ? trim($params['to_date']) : '';
    $sortBy = isset($params['sort_by']) ? $params['sort_by'] : '';
    $sortOrd = isset($params['sort_order']) ? $params['sort_order'] : 'DESC';


    //$query = $this->where('id', '>', 0);
    $query = $this->leftJoin('users', 'users.id', '=', 'tb_gh.user_id');
    $query->select(['tb_gh.*']);

    if (isset($params['pending_gh_only']) && $params['pending_gh_only'] == true) {
      $query->where('tb_gh.pending_amount', '>', 0);
    }

    // filter query 

    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {

        $query->whereRaw(
                "(
                                    (tb_gh.transaction_code LIKE '%" . $searchText . "%') OR
                                    (users.username LIKE '%" . $searchText . "%') OR
                                    (tb_gh.amount LIKE '%" . $searchText . "%') OR
                                    (tb_gh.status LIKE '%" . $searchText . "%')
                                      
                                )");
      } else {
        $query->where($searchField, 'LIKE', '%' . $searchText . '%');
      }
    }


    if ($from_date != "") {
      $from_date = \Carbon\Carbon::createFromFormat('m/d/Y', $from_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(" . $this->table . ".created_at, '%Y-%m-%d') >= '$from_date'");
    }

    if ($to_date != "") {
      $to_date = \Carbon\Carbon::createFromFormat('m/d/Y', $to_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(" . $this->table . ".created_at, '%Y-%m-%d') <= '$to_date'");
    }

    // sort query
    if ($sortBy != "" && $sortOrd != "") {
      $query->orderBy($sortBy, $sortOrd);
    } else {
      $query->orderBy($this->table . '.id', 'DESC');
    }

    $record_per_page = (isset($params['record_per_page']) && $params['record_per_page'] != "" && $params['record_per_page'] > 0) ? $params['record_per_page'] : env('APP_RECORDS_PER_PAGE', 1);
    return $query->paginate($record_per_page);
  }
}
