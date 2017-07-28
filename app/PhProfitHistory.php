<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhProfitHistory extends Model
{
    protected $fillable = [
      'ph_id', 'user_id', 'manager_id',
      'level_number', 'profit_percentage', 'profit_amount',
  ];
  protected $table = 'ph_profit_history';

  public function PH() {
    return $this->belongsTo('\App\PH', 'ph_id');
  }
  
  public function manager() {
    return $this->belongsTo('\App\Manager', 'manager_id');
  }

  public static function myPHProfitHistory($user_id, $list_params = []) {

    $searchField = isset($list_params['search_field']) ? trim($list_params['search_field']) : '';
    $searchText = isset($list_params['search_text']) ? trim($list_params['search_text']) : '';
    $from_date = isset($list_params['from_date']) ? trim($list_params['from_date']) : '';
    $to_date = isset($list_params['to_date']) ? trim($list_params['to_date']) : '';
    $sortBy = isset($list_params['sort_by']) ? $list_params['sort_by'] : '';
    $sortOrd = isset($list_params['sort_order']) ? $list_params['sort_order'] : 'DESC';


    $query = PhProfitHistory::where('ph_profit_history.level_number', '=', '0')
            ->leftJoin('tb_ph', 'tb_ph.id', '=', 'ph_id')
            //->where('tb_ph.status', '=', 'approved')
            ->where('ph_profit_history.user_id', '=', $user_id)
            ->select('ph_profit_history.*');


    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {
        $query->whereRaw(
                "(
                                    (tb_ph.transaction_code LIKE '%" . $searchText . "%') OR
                                    (ph_profit_history.profit_percentage LIKE '%" . $searchText . "%') OR
                                    (ph_profit_history.profit_amount LIKE '%" . $searchText . "%')
                                )");
      } else {
        $query->where($searchField, 'LIKE', '%' . $searchText . '%');
      }
    }

    if ($from_date != "") {
      $from_date = \Carbon\Carbon::createFromFormat('m/d/Y', $from_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(ph_profit_history.created_at, '%Y-%m-%d') >= '$from_date'");
    }

    if ($to_date != "") {
      $to_date = \Carbon\Carbon::createFromFormat('m/d/Y', $to_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(ph_profit_history.created_at, '%Y-%m-%d') <= '$to_date'");
    }

    //dd($list_params);

    if (isset($list_params['sort_by']) && $list_params['sort_by'] != '') {
      $query->orderBy($list_params['sort_by'], $list_params['sort_order']);
    }

    return $query->paginate(25);
  }

  public static function myDownlinePHProfitHistory($user_id, $list_params = []) {

    $searchField = isset($list_params['search_field']) ? trim($list_params['search_field']) : '';
    $searchText = isset($list_params['search_text']) ? trim($list_params['search_text']) : '';
    $from_date = isset($list_params['from_date']) ? trim($list_params['from_date']) : '';
    $to_date = isset($list_params['to_date']) ? trim($list_params['to_date']) : '';
    $sortBy = isset($list_params['sort_by']) ? $list_params['sort_by'] : '';
    $sortOrd = isset($list_params['sort_order']) ? $list_params['sort_order'] : 'DESC';


    $query = PhProfitHistory::where('ph_profit_history.level_number', '!=', '0')
            ->leftJoin('tb_ph', 'tb_ph.id', '=', 'ph_id')
            ->where('tb_ph.status', '=', 'approved')
            ->where('ph_profit_history.manager_id', '=', NULL)
            ->where('ph_profit_history.user_id', '=', $user_id)
            ->select('ph_profit_history.*');


    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {
        $query->whereRaw(
                "(
                                    (tb_ph.transaction_code LIKE '%" . $searchText . "%') OR
                                    (ph_profit_history.profit_percentage LIKE '%" . $searchText . "%') OR
                                    (ph_profit_history.profit_amount LIKE '%" . $searchText . "%')
                                )");
      } else {
        $query->where($searchField, 'LIKE', '%' . $searchText . '%');
      }
    }

    if ($from_date != "") {
      $from_date = \Carbon\Carbon::createFromFormat('m/d/Y', $from_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(ph_profit_history.created_at, '%Y-%m-%d') >= '$from_date'");
    }

    if ($to_date != "") {
      $to_date = \Carbon\Carbon::createFromFormat('m/d/Y', $to_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(ph_profit_history.created_at, '%Y-%m-%d') <= '$to_date'");
    }

    //dd($list_params);

    if (isset($list_params['sort_by']) && $list_params['sort_by'] != '') {
      $query->orderBy($list_params['sort_by'], $list_params['sort_order']);
    }

    return $query->paginate(25);
  }

  public static function directorPHProfitHistory($user_id, $list_params = []) {

    $searchField = isset($list_params['search_field']) ? trim($list_params['search_field']) : '';
    $searchText = isset($list_params['search_text']) ? trim($list_params['search_text']) : '';
    $from_date = isset($list_params['from_date']) ? trim($list_params['from_date']) : '';
    $to_date = isset($list_params['to_date']) ? trim($list_params['to_date']) : '';
    $sortBy = isset($list_params['sort_by']) ? $list_params['sort_by'] : '';
    $sortOrd = isset($list_params['sort_order']) ? $list_params['sort_order'] : 'DESC';


    $query = PhProfitHistory::where('ph_profit_history.level_number', '!=', '0')
            ->leftJoin('tb_ph', 'tb_ph.id', '=', 'ph_id')
            ->where('tb_ph.status', '=', 'approved')
            ->where('ph_profit_history.manager_id', '>', 0)
            ->where('ph_profit_history.user_id', '=', $user_id)
            ->select('ph_profit_history.*');


    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {
        $query->whereRaw(
                "(
                                    (tb_ph.transaction_code LIKE '%" . $searchText . "%') OR
                                    (ph_profit_history.profit_percentage LIKE '%" . $searchText . "%') OR
                                    (ph_profit_history.profit_amount LIKE '%" . $searchText . "%')
                                )");
      } else {
        $query->where($searchField, 'LIKE', '%' . $searchText . '%');
      }
    }

    if ($from_date != "") {
      $from_date = \Carbon\Carbon::createFromFormat('m/d/Y', $from_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(ph_profit_history.created_at, '%Y-%m-%d') >= '$from_date'");
    }

    if ($to_date != "") {
      $to_date = \Carbon\Carbon::createFromFormat('m/d/Y', $to_date)->format('Y-m-d');
      $query->whereRaw("DATE_FORMAT(ph_profit_history.created_at, '%Y-%m-%d') <= '$to_date'");
    }

    //dd($list_params);

    if (isset($list_params['sort_by']) && $list_params['sort_by'] != '') {
      $query->orderBy($list_params['sort_by'], $list_params['sort_order']);
    }

    return $query->paginate(25);
  }
}
