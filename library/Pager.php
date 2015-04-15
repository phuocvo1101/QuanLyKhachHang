<?php
class Pagination
{

    public $limit = ''; // sá»‘ record hiá»ƒn thá»‹ trÃªn má»™t trang
// protected $_baseUrl;


    public function Pagination($limit)//$base_url
    {
        //$this->_baseUrl = $base_url;
        $this->limit = $limit;
    }
    /**
    - Tìm ra vị trí start
     */
    public function start(){
        if(isset($_REQUEST['start'])){
            $start = $_REQUEST['start'];
        }else{
            $start = 0;
        }
        return $start;
    }

    /**
    - Tìm ra tổng số trang
     */
    public function totalPages($totalRecord){
        if(isset($_REQUEST['pages']) && !empty($_REQUEST['pages'])){
            $totalPages = $_REQUEST['pages'];
        }else{
            $totalPages = ceil($totalRecord/$this->limit);

        }
        return $totalPages;
    }

    /**
    - Gọi ra list phân trang
     */
    public function listPages($totalPages){
        $start = $this->start();
        $limit = $this->limit;
        $listPage = '';

        if($totalPages > 1){ // sá»‘ trang pháº£i tá»« 2 trang trá»Ÿ lÃªn
            $current = ($start/$limit) + 1; // trang hiá»‡n táº¡i
            if($current != 1){ // NÃºt prev
                $newstart = $start - $limit;
                $listPage .= "<a onclick='getPage(".$totalPages.",".$newstart.",".$limit.");' href='javascript:void(0);'>Prev</a>";
            }


            for($i=1;$i<=$totalPages;$i++){  // Táº¥t cáº£ cÃ¡c trang tÃ¬m Ä‘Æ°á»£c
                $newstart = ($i - 1)*$limit;
                if($i == $current){
                    $listPage .= "<span class='current'>".$i."</span>";
                }else{
                    $listPage .= "<a onclick='getPage(".$totalPages.",".$newstart.",".$limit.");' href='javascript:void(0);'>".$i."</a>";
                }
            }

            if($current != $totalPages){ // NÃºt next
                $newstart = $start + $limit;
                $listPage .= "<a onclick='getPage(".$totalPages.",".$newstart.",".$limit.");' href='javascript:void(0);'>Next</a>";
            }
        }

        return $listPage;
    }
}