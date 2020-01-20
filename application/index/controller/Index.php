<?php
namespace app\index\controller;

use think\facade\Request;
use think\facade\Lang;
use app\index\controller\Base;
use think\facade\Config;
use app\common\model\BuildUrl;
use app\common\model\DocumentContent;

class Index extends Base
{
    public function index()
    {
        return $this->fetch('index');
    }

    public function solution()
    {
        return $this->fetch('solution');
    }

    public function news()
    {
        // $query = [
        //     'site_id' => $this->site_id,
        //     'cid'     => isset($request['cid']) ? $request['cid'] : '',
        //     'q'       => isset($request['q']) ? $request['q'] : '',
        //     'option'  => isset($request['option']) ? $request['option'] : '',
        // ];

        $args = [
            //'query'  => $query,
            'field'  => '',
            'order'  => 'id desc',
            //'params' => $query,
            'limit'  => 3,
        ];
        // 文档信息
        $documentObj = new DocumentContent;
        $list = $documentObj->select($args);
        $data = [
            //'search'   => $query,
            //'category' => $category,
            'list'     => $list,
            'page'     => $list->render(),
            //'option'   => Config::get('site.document_option'),
        ];
        //halt($list->render());
        //return $this->fetch($category->detail_tpl, $data);
        return $this->fetch('news', $data);
    }

    public function news_detail()
    {
        $id = Request::param('id');
        $docObj = new DocumentContent;
        $document = $docObj->getDetail($id);
        if (!isset($document)) {
              $this->error(404);
        } else if($document->role_id !== 0) {
              $role_ids = [];
              if (!empty($this->role)) {
                  $role_ids =  array_column($this->role, 'role_id');
              }

              if (!in_array($document->role_id, $role_ids)) {
                  $this->error(Lang::get('Your role does not have access'));
              }
        } else {
            // 访问量+1
            $document->pv = $document->pv + 1;
            $document->save();

            // 评论总数
            //$document->comments_total = $commObj->getCommentsCount($document->id);
        }

        // 上一条信息
        $previous = $docObj->getDocumentPrevious($this->site_id, $id);
        if (isset($previous)) {
            $previous->url = BuildUrl::instance($this->site_id)->documentUrl(['id' => $previous->id]);
        }
//halt($document);
        // 下一条信息
        $next = $docObj->getDocumentNext($this->site_id, $id);
        if (isset($next)) {
            $next->url = BuildUrl::instance($this->site_id)->documentUrl(['id' => $next->id]);
        }

        $data = [
            'docinfo'  => $document,
            //'catinfo'  => $category,
            'prev'     => $previous,
            'next'     => $next,
            //'commlist' => list_for_level($comments),
            //'commpage' => $comments->render(),
        ];
        return $this->fetch('news_detail',$data);
    }

    public function about()
    {
        return $this->fetch('about');
    }

    public function contact()
    {
        return $this->fetch('contact');
    }
}
