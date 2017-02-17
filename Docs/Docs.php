<?php
namespace App\Phase\Docs;

use Cache;
use DB;

class Docs
{
	protected $locale = "";

	protected $id = 'id';

	public function __construct()
	{
		if(\App::getLocale() == 'nl'){
            $this->locale = 'dutch';
            $this->id = 'parentid';
        }
	}

	public function menu()
	{
        $menu = Cache::remember('menu_docs', 10, function()
		{
		    return DB::connection('mysql_whmcs')
	            ->table('tblknowledgebasecats')
	            ->where('parentid', 0)
	            ->get();
		});

		return $menu;
	}

	public function getArticles($categoryid)
	{
		$links = DB::connection('mysql_whmcs')
			->table('tblknowledgebaselinks')
			->where('categoryid', $categoryid)
			->get();

		$articles = array();
		foreach($links as $key => $link){
			$articles[] = $link->articleid;
		}

		return DB::connection('mysql_whmcs')
            ->table('tblknowledgebase')
            ->whereIn($this->id, $articles)
            ->get();

	}

	public function getArticle($articleid)
	{	
		$article = DB::connection('mysql_whmcs')
            ->table('tblknowledgebase')
            ->where(['id' => $articleid, 'language' => $this->locale])
            ->first();

		if($this->locale == "dutch" && !$article)
		{
			$article = DB::connection('mysql_whmcs')
	            ->table('tblknowledgebase')
	            ->where([$this->id => $articleid])
	            ->first();
		}

		if($this->locale == "" && !$article)
		{
			$article = DB::connection('mysql_whmcs')
	            ->table('tblknowledgebase')
	            ->where(['id' => $articleid])
	            ->first();


	        $this->getArticle($article->parentid);
		}
		
		return $article;
	}
}