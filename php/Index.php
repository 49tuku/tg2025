<?php

namespace app\api\controller;

use app\common\controller\Api;
use QL\QueryList;
use think\Db;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success('请求成功');
    }

    /**
     * 彩图
     */
    public function am1(){
        set_time_limit(0);
        $domain = 'https://628818.5kanglin.com/';
        $url = $domain.'k_imageslist.aspx';
        $rules = [
            // DOM解析文章标题
            'title' => ['a','html'],
            // DOM解析文章作者
            'href' => ['a','href'],
        ];
        $rt = QueryList::get($url)->rules($rules)->range('.indexed-list li')->query()->getData();
        $list = $rt->all();
        foreach ($list as $item){
            $tq = QueryList::html($item['title']);
            $tq->find('span')->remove();

            //2.解析参数
            $udata = parse_url($domain.$item['href']);
            parse_str($udata['query'], $params);

            //3.验证分类是否存在
            $tu = Db::name('tu')->where(['typeId'=>$params['id'], 'type'=>1])->find();
            if($tu){
                Db::name('tu')->where(['typeId'=>$params['id']])->update(['qi'=>$params['qi']]);
            }else{
                continue;
            }
            //4.验证图片是否存在
            $pic = Db::name('tulist')->where(['qi'=>$params['qi'], 'tu_id'=>$tu['id']])->find();
            if(!$pic){
                //采集图片
                $tulist = [];
                $picurl = 'https://tk2.shuangshuangjieyanw.com:4949/col/'.$params['qi'].'/'.$tu['pic'];
                $tulist[] = ['pictureId'=>$params['id'],'qi'=>$params['qi'], 'pic'=>$tu['pic'], 'tu_id'=>$tu['id'], 'picurl'=>$picurl];
                Db::name('tulist')->insertAll($tulist);
            }

        }
        echo 'ok';
    }

    /**
     * 黑白
     */
    public function am2(){
        set_time_limit(0);
        $domain = 'https://628818.5kanglin.com/';
        $url = $domain.'k_imageslist2.aspx';
        $rules = [
            // DOM解析文章标题
            'title' => ['a','html'],
            // DOM解析文章作者
            'href' => ['a','href'],
        ];
        $rt = QueryList::get($url)->rules($rules)->range('.indexed-list li')->query()->getData();
        $list = $rt->all();
        foreach ($list as $item){
            $tq = QueryList::html($item['title']);
            $tq->find('span')->remove();

            //2.解析参数
            $udata = parse_url($domain.$item['href']);
            parse_str($udata['query'], $params);

            //3.验证分类是否存在
            $tu = Db::name('tu')->where(['typeId'=>$params['id'], 'type'=>2])->find();
            if($tu){
                Db::name('tu')->where(['typeId'=>$params['id']])->update(['qi'=>$params['qi']]);
            }else{
                continue;
            }
            //4.验证图片是否存在
            $pic = Db::name('tulist')->where(['qi'=>$params['qi'], 'tu_id'=>$tu['id']])->find();
            if(!$pic){
                //采集图片
                $tulist = [];
                $picurl = 'https://tk2.shuangshuangjieyanw.com:4949/col/'.$params['qi'].'/'.$tu['pic'];
                $tulist[] = ['pictureId'=>$params['id'],'qi'=>$params['qi'], 'pic'=>$tu['pic'], 'tu_id'=>$tu['id'], 'picurl'=>$picurl];
                Db::name('tulist')->insertAll($tulist);
            }

        }
        echo 'ok';
    }



    /**
     * 彩图
     */
    public function xginit1(){
        set_time_limit(0);
        $tytype = 1;
        $domain = 'https://www.hk072.com/';
        $url = $domain.'photo-color.html?type=1';
        $rules = [
            // DOM解析文章标题
            'title' => ['a','html'],
            // DOM解析文章作者
            'href' => ['a','href'],
        ];
        $rt = QueryList::get($url)->rules($rules)->range('.ablum ul li')->query()->getData();
        $list = $rt->all();
        foreach ($list as $item){
            $tq = QueryList::html($item['title']);
            //最后1期
            $latestqi = $tq->find('label')->text();
            $tq->find('span')->remove();
            //名称
            $title = trim($tq->getHtml());

            $ql = QueryList::get($domain.$item['href']);
            //1.获取文件名
            $tmprules = [
                // DOM解析文章标题
                'qid' => ['.qid', 'data-number'],
                // DOM解析文章作者
                'picid' => ['.qid','data-id'],
            ];
            $qilist = $ql->range('.swiper-wrapper .swiper-slide')->rules($tmprules)->query()->getData();

            //3.验证分类是否存在
            $tu = Db::name('tu_copy')->where(['name'=>$title, 'type'=>$tytype])->find();
            if(!$tu){
                $tu['id'] = Db::name('tu_copy')->insertGetId(['qi'=>$latestqi, 'pic'=>'', 'name'=>$title, 'type'=>$tytype]);
            }
            $piclist = $qilist->all();
            $picdata = [];
            foreach ($piclist as $pp){
                $picurl = 'https://www.hk072.com/photo/index/img/?id='.$pp['picid'];
                $pic = Db::name('tulist_copy')->where(['picurl'=>$picurl])->find();
                if(!$pic){
                    $picdata[] = ['tu_id'=>$tu['id'], 'picurl'=>$picurl, 'qi'=>$pp['qid']];
                }
            }
            if($picdata){
                Db::name('tulist_copy')->insertAll($picdata);
            }
        }
        echo 'ok';
    }

    /**
     * 黑白
     */
    public function xginit2(){
        set_time_limit(0);
        $tytype = 1;
        $domain = 'https://www.hk072.com/';
        $url = $domain.'photo-black.html?type=1';
        $rules = [
            // DOM解析文章标题
            'title' => ['a','html'],
            // DOM解析文章作者
            'href' => ['a','href'],
        ];
        $rt = QueryList::get($url)->rules($rules)->range('.ablum ul li')->query()->getData();
        $list = $rt->all();
        foreach ($list as $item){
            $tq = QueryList::html($item['title']);
            //最后1期
            $latestqi = $tq->find('label')->text();
            $tq->find('span')->remove();
            //名称
            $title = trim($tq->getHtml());

            $ql = QueryList::get($domain.$item['href']);
            //1.获取文件名
            $tmprules = [
                // DOM解析文章标题
                'qid' => ['.qid', 'data-number'],
                // DOM解析文章作者
                'picid' => ['.qid','data-id'],
            ];
            $qilist = $ql->range('.swiper-wrapper .swiper-slide')->rules($tmprules)->query()->getData();

            //3.验证分类是否存在
            $tu = Db::name('tu_copy')->where(['name'=>$title, 'type'=>$tytype])->find();
            if(!$tu){
                $tu['id'] = Db::name('tu_copy')->insertGetId(['qi'=>$latestqi, 'pic'=>'', 'name'=>$title, 'type'=>$tytype]);
            }
            $piclist = $qilist->all();
            $picdata = [];
            foreach ($piclist as $pp){
                $picurl = 'https://www.hk072.com/photo/index/img/?id='.$pp['picid'];
                $pic = Db::name('tulist_copy')->where(['picurl'=>$picurl])->find();
                if(!$pic){
                    $picdata[] = ['tu_id'=>$tu['id'], 'picurl'=>$picurl, 'qi'=>$pp['qid']];
                }
            }
            if($picdata){
                Db::name('tulist_copy')->insertAll($picdata);
            }
        }
        echo 'ok';
    }


}
