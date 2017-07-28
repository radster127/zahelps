<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Pair extends Model
{
    //
	 protected $fillable = [
	      'ph_id', 'gh_id',
	      'expired_on', 'auto_approved_on', 'approved_on', 'reason',
	      'status', 'payment_type',
	      'amount', 'transferred_amount', 'token', 'proof_picture',
	      'admin_generated',
	];
	protected $table = 'tb_pair';
	protected $searchColumns = [
	      'all' => 'All',
	      'tb_ph.transaction_code' => 'Ph Tran. Code',
	      'tb_gh.transaction_code' => 'Gh Tran. Code',
	      'user' => 'Member',
	      'tb_pair.amount' => 'Amount',
	      'tb_pair.status' => 'Status',
	];

	public function getSearchColumns() {
	    return $this->searchColumns;
	}

	public function PH() {
	    return $this->belongsTo('\App\PH', 'ph_id');
	}

    public function GH() {
    	return $this->belongsTo('\App\GH', 'gh_id');
  	}

	public static function myPairedPH($user_id = 0, $statusArr = ['paired']) {
	    if ($user_id == 0) {
	      $user_id = Auth::user()->id;
	    }
	    $whereArray = [
	        ['tb_ph.user_id', '=', $user_id],
	    ];

	    $query = self::where($whereArray);
	    $query->whereIn('tb_pair.status', $statusArr);
	    $query->leftJoin('tb_ph', 'tb_ph.id', '=', 'ph_id');
	    $query->select(['tb_pair.*']);
	    $query->orderBy('tb_pair.id', 'DESC');
	    return $query->get();
	}

	public static function myPairedGH($user_id = 0, $statusArr = ['paired']) {
	    if ($user_id == 0) {
	      $user_id = Auth::user()->id;
	    }
	    $whereArray = [
	        ['tb_gh.user_id', '=', $user_id]
	    ];
	    $query = self::where($whereArray);
	    $query->whereIn('tb_pair.status', $statusArr);
	    $query->leftJoin('tb_gh', 'tb_gh.id', '=', 'gh_id');
	    $query->select(['tb_pair.*']);
	    $query->orderBy('tb_pair.id', 'DESC');

	    return $query->get();
	}

	public static function findByGHId($gh_id) {
	    // find pairs by gh_id
	    return Pair::where('gh_id', '=', $gh_id)->get();
	}

	public static function findByPHId($ph_id) {
	    // find pairs by ph_id
	    return Pair::where('ph_id', '=', $ph_id)->get();
	}

  public function getAdminList($params) {
    $searchField = isset($params['search_field']) ? trim($params['search_field']) : '';
    $searchText = isset($params['search_text']) ? trim($params['search_text']) : '';
    $from_date = isset($params['from_date']) ? trim($params['from_date']) : '';
    $to_date = isset($params['to_date']) ? trim($params['to_date']) : '';
    $sortBy = isset($params['sort_by']) ? $params['sort_by'] : '';
    $sortOrd = isset($params['sort_order']) ? $params['sort_order'] : 'DESC';


    //$query = $this->where('id', '>', 0);
    $query = $this->leftJoin('tb_gh', 'tb_gh.id', '=', 'tb_pair.gh_id');
    $query->leftJoin('tb_ph', 'tb_ph.id', '=', 'tb_pair.ph_id');

    $query->leftJoin('users AS ph_user', 'ph_user.id', '=', 'tb_ph.user_id');
    $query->leftJoin('users AS gh_user', 'gh_user.id', '=', 'tb_gh.user_id');


    $query->select(['tb_pair.*']);

    // filter query 

    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {

        $query->whereRaw(
                "(
                                    (tb_ph.transaction_code LIKE '%" . $searchText . "%') OR
                                    (tb_gh.transaction_code LIKE '%" . $searchText . "%') OR
                                    (tb_pair.amount LIKE '%" . $searchText . "%') OR
                                    (tb_pair.status LIKE '%" . $searchText . "%')
                                )");
      } elseif ($searchField == "user") {
        $query->whereRaw(
                "(
                                    (ph_user.username LIKE '%" . $searchText . "%') OR
                                    (gh_user.username LIKE '%" . $searchText . "%')
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
