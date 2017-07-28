<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  protected $fillable = [
      'page_name', 'page_title', 'meta_title', 'meta_keywords', 'meta_description', 'content'
  ];
  protected $searchColumns = [
      'all' => 'All',
      'pages.page_name' => 'Page Name',
  ];
  protected $table = 'pages';

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


    $query = $this->where('id', '>', 0);

    // filter query 

    if ($searchField != "" && $searchText != "") {
      if ($searchField == "all") {
        $query->whereRaw(
                "(
                                    (" . $this->table . ".page_name LIKE '%" . $searchText . "%')
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
      $query->orderBy($this->table . '.id', 'ASC');
    }

    $record_per_page = (isset($params['record_per_page']) && $params['record_per_page'] != "" && $params['record_per_page'] > 0) ? $params['record_per_page'] : env('APP_RECORDS_PER_PAGE', 1);
    return $query->paginate($record_per_page);
  }
}
