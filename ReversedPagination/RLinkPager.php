<?php
/**
 * RLinkPager class file.
 *
 * @author DeusModus <maximebaldin@gmail.com>
 * @link http://deusmodus.ru/
 * @license BSD
 */

/**
 * RLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author DeusModus <maximebaldin@gmail.com>
 */
class RLinkPager extends CLinkPager {

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		$buttons[]=$this->createPageButton($this->firstPageLabel,$pageCount-1,self::CSS_FIRST_PAGE,$currentPage<=0,false);

		// prev page

		if(($page=$pageCount-$currentPage)>=$pageCount){
            $page=$pageCount-1;
        }

		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);
		// internal pages
		for($i=$endPage;$i>=$beginPage;--$i){
            $buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$pageCount-1-$currentPage);
        }

		// next page

        if(($page=$pageCount-$currentPage-2)<=0){
            $page=0;
        }
        $buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,0,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	/**
	 * @return array the begin and end pages that need to be displayed.
	 */
	protected function getPageRange()
	{
		$currentPage=$this->getCurrentPage();
		$pageCount=$this->getPageCount();
		$beginPage=max(0, $pageCount-$currentPage-(int)($this->maxButtonCount/2));
		if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
		{
			$endPage=$pageCount-1;
			$beginPage=max(0,$endPage-$this->maxButtonCount+1);
		}
		return array($beginPage,$endPage);
	}
}
