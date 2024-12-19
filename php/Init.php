<?php

namespace app\api\controller;

use app\common\controller\Api;
use QL\QueryList;
use think\Db;

/**
 * 首页接口
 */
class Init extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];


    /**
     * 彩图
     */
    public function aminit1(){
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
            $title = trim($tq->getHtml());

            $ql = QueryList::get($domain.$item['href']);
            //1.获取文件名
            $picname = $ql->find("div[data-i='001']")->attr('data-name');
            //2.解析参数
            $udata = parse_url($domain.$item['href']);
            parse_str($udata['query'], $params);

            //3.验证分类是否存在
            $tu = Db::name('tu')->where(['typeId'=>$params['id'], 'type'=>1])->find();
            if($tu){
                Db::name('tu')->where(['typeId'=>$params['id']])->update(['qi'=>$params['qi'], 'name'=>$title]);
            }else{
                $tu['id'] = Db::name('tu')->insertGetId(['typeId'=>$params['id'],'qi'=>$params['qi'], 'pic'=>$picname, 'name'=>$title, 'type'=>1]);
            }
            //4.验证图片是否存在
            $pic = Db::name('tulist')->where(['qi'=>$params['qi'], 'tu_id'=>$tu['id']])->find();
            if(!$pic){
                //采集图片
                $tulist = [];
                for($i = 1; $i <= $params['qi']; $i++){
                    $picurl = 'https://tk2.shuangshuangjieyanw.com:4949/col/'.($i*1).'/'.$picname;
                    $tulist[] = ['pictureId'=>$params['id'],'qi'=>str_pad($i, 3, '0', STR_PAD_LEFT), 'pic'=>$picname, 'tu_id'=>$tu['id'], 'picurl'=>$picurl];
                }
                Db::name('tulist')->insertAll($tulist);
            }

        }
        echo 'ok';
    }

    /**
     * 黑白
     */
    public function aminit2(){
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
            $title = trim($tq->getHtml());

            $ql = QueryList::get($domain.$item['href']);
            //1.获取文件名
            $picname = $ql->find("div[data-i='001']")->attr('data-name');
            //2.解析参数
            $udata = parse_url($domain.$item['href']);
            parse_str($udata['query'], $params);

            //3.验证分类是否存在
            $tu = Db::name('tu')->where(['typeId'=>$params['id'], 'type'=>2])->find();
            if($tu){
                Db::name('tu')->where(['typeId'=>$params['id']])->update(['qi'=>$params['qi'], 'name'=>$title]);
            }else{
                $tu['id'] = Db::name('tu')->insertGetId(['typeId'=>$params['id'],'qi'=>$params['qi'], 'pic'=>$picname, 'name'=>$title, 'type'=>2]);
            }
            //4.验证图片是否存在
            $pic = Db::name('tulist')->where(['qi'=>$params['qi'], 'tu_id'=>$tu['id']])->find();
            if(!$pic){
                //采集图片
                $tulist = [];
                for($i = 1; $i <= $params['qi']; $i++){
                    $picurl = 'https://tk2.shuangshuangjieyanw.com:4949/col/'.($i*1).'/'.$picname;
                    $tulist[] = ['pictureId'=>$params['id'],'qi'=>str_pad($i, 3, '0', STR_PAD_LEFT), 'pic'=>$picname, 'tu_id'=>$tu['id'], 'picurl'=>$picurl];
                }
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
            Db::name('tulist_copy')->insertAll($picdata);
        }
        echo 'ok';
    }

    /**
     * 黑白
     */
    public function xginit2(){
        set_time_limit(0);
        $tytype = 2;
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
            Db::name('tulist_copy')->insertAll($picdata);
        }
        echo 'ok';
    }


}
