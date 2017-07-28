<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PH extends Model
{
    protected $fillable = [
      'user_id', 'transaction_code',
      'profit_per_day_percentage', 'profit_total_days', 'profit_day_counter',
      'user_information',
      'amount', 'pending_amount',
      'admin_commission_percentage', 'admin_commission',
      'ph_capital', 'ph_profit', 'profit_start_datetime',
      'profit_credited', 'profit_credited_datetime',
      'lock_ph', 'ip_address', 'status', 'old_id', 'is_freeze'
  ];
  protected $table = 'tb_ph';

  public function user() {
    return $this->belongsTo('\App\User', 'user_id');
  }

  public static function myPendingPH($user_id = 0) {
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

  protected $searchColumns = [
      'all' => 'All',
      'tb_ph.transaction_code' => 'Code',
      'users.username' => 'Member',
      'tb_ph.amount' => 'Amount',
      'tb_ph.status' => 'Status',
  ];

  public function getSearchColumns() {
    return $this->searchColumns;
  }

  public function getAdminList($params) {
    $searchField = isset($params['search_field']) ? trim($params['search_field']) : '';
    $searchText = isset($params['search_text']) ? trim($params['search_text']) : '';
    $from_date = isset($params['from_date']) ? trim($params['from_date']) : '';
    $to_date = isset($params['to_date']) ? trim($params['to_date']) : '';
    $sortBy = isset($params['sort_by']) ? $params['sort_by'] : '';
    $sortOrd = isset($params['sort_order']) ? $params['sort_order'] : 'DESC';


    //$query = $this->where('id', '>', 0);
    $query = $this->leftJoin('users', 'users.id', '=', 'tb_ph.user_id');
    $query->select(['tb_ph.*']);

    // filter query 

    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {

        $query->whereRaw(
                "(
                                    (tb_ph.transaction_code LIKE '%" . $searchText . "%') OR
                                    (users.username LIKE '%" . $searchText . "%') OR
                                    (tb_ph.amount LIKE '%" . $searchText . "%') OR
                                    (tb_ph.status LIKE '%" . $searchText . "%')
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

  public static function myPHProfitHistory($user_id = 0, $params) {
    $searchField = isset($params['search_field']) ? trim($params['search_field']) : '';
    $searchText = isset($params['search_text']) ? trim($params['search_text']) : '';
    $from_date = isset($params['from_date']) ? trim($params['from_date']) : '';
    $to_date = isset($params['to_date']) ? trim($params['to_date']) : '';
    $sortBy = isset($params['sort_by']) ? $params['sort_by'] : '';
    $sortOrd = isset($params['sort_order']) ? $params['sort_order'] : 'DESC';


    //$query = $this->where('id', '>', 0);
    $query = PH::leftJoin('users', 'users.id', '=', 'tb_ph.user_id');
    $query->where('tb_ph.user_id', '=', $user_id);
    $query->select(['tb_ph.*']);

    // filter query 

    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {

        $query->whereRaw(
                "(
                                    (tb_ph.transaction_code LIKE '%" . $searchText . "%') OR
                                    (users.username LIKE '%" . $searchText . "%') OR
                                    (tb_ph.amount LIKE '%" . $searchText . "%') OR
                                    (tb_ph.status LIKE '%" . $searchText . "%')
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
      $query->orderBy('tb_ph.id', 'DESC');
    }

    $record_per_page = (isset($params['record_per_page']) && $params['record_per_page'] != "" && $params['record_per_page'] > 0) ? $params['record_per_page'] : env('APP_RECORDS_PER_PAGE', 1);
    return $query->paginate($record_per_page);
  }
}
