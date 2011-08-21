<?php
/**
 * RPagination class file.
 *
 * @author DeusModus <maximebaldin@gmail.com>
 * @link http://deusmodus.ru/
 * @license BSD
 */

/**
 * RPagination represents information relevant to pagination.
 *
 * When data needs to be rendered in multiple pages, we can use RPagination to
 * represent information such as {@link getItemCount total item count},
 * {@link getPageSize page size}, {@link getCurrentPage current page}, etc.
 * These information can be passed to {@link CBasePager pagers} to render
 * pagination buttons or links.
 *
 * Example:
 *
 * Controller action:
 * <pre>
 * function actionIndex(){
 *     $criteria = new CDbCriteria();
 *     $count=Article::model()->count($criteria);
 *     $pages=new CPagination($count);
 *
 *     // results per page
 *     $pages->pageSize=10;
 *     $pages->applyLimit($criteria);
 *     $models = Post::model()->findAll($criteria);
 *
 *     $this->render('index', array(
 *     'models' => $models,
 *          'pages' => $pages
 *     ));
 * }
 * </pre>
 *
 * View:
 * <pre>
 * <?php foreach($models as $model): ?>
 *     // display a model
 * <?php endforeach; ?>
 *
 * // display pagination
 * <?php $this->widget('CLinkPager', array(
 *     'pages' => $pages,
 * )) ?>
 * </pre>
 *
 * @author DeusModus <maximebaldin@gmail.com>
 */
class RPagination extends CPagination
{
    private $_currentPage;

     /*
	 * @param boolean $recalculate whether to recalculate the current page based on the page size and item count.
	 * @return integer the zero-based index of the current page. Defaults to 0.
	 */
    public function getCurrentPage($recalculate = true)
    {
        if ($this->_currentPage === null || $recalculate) {
            if (isset($_GET[$this->pageVar])) {
                $this->_currentPage = (int)$_GET[$this->pageVar] - 1;
                if ($this->validateCurrentPage) {
                    $pageCount = $this->getPageCount();
                    if ($this->_currentPage >= $pageCount){
                        $this->_currentPage = $pageCount - 1;
                    }
                }
                if ($this->_currentPage < 0){
                    $this->_currentPage = 0;
                }
            }
            else{
                $this->_currentPage = $this->getPageCount()-1;
            }
        }
        $reversePageNumber = $this->getPageCount() - $this->_currentPage - 1;
        return $reversePageNumber;
    }

	public function createPageUrl($controller,$page)
	{
		$params=$this->params===null ? $_GET : $this->params;
		if($page>=0 && $page!=$this->getPageCount()-1) // last page is the default
			$params[$this->pageVar]=$page+1;
        else{
            unset($params[$this->pageVar]);
        }
		return $controller->createUrl($this->route,$params);
	}
}
