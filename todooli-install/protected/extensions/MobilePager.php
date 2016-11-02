<?php
class MobilePager extends CLinkPager{
	
	
	const CSS_FIRST_PAGE='first';
	const CSS_FIRST_PAGE_HIDDEN='first-hidden';
	const CSS_LAST_PAGE='last';
	const CSS_LAST_PAGE_HIDDEN='last-hidden';
	const CSS_PREVIOUS_PAGE='previous';
	const CSS_PREVIOUS_PAGE_HIDDEN='previous-hidden';
	const CSS_NEXT_PAGE='next';
	const CSS_NEXT_PAGE_HIDDEN='next-hidden';
	const CSS_INTERNAL_PAGE='page';
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='selected';

	/**
	 * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
	 */
	public $maxButtonCount=1;
	/**
	 * @var string the text label for the next page button. Defaults to 'Next &gt;'.
	 */
	public $nextPageLabel;
	/**
	 * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
	 */
	public $prevPageLabel;
	/**
	 * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
	 */
	public $firstPageLabel;
	/**
	 * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
	 */
	public $lastPageLabel;
	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to page: '.
	 */
	public $header;
	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer='';
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile;
	public $extraPara;
	/**
	 * @var array HTML attributes for the pager container tag.
	 */
	public $htmlOptions=array();

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','&nbsp;');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&nbsp;');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','&nbsp;');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','&nbsp;');
		if($this->header===null)
			$this->header=Yii::t('yii','&nbsp;');

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='yiiPager';
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		
		$currentPage=$this->getCurrentPage(false)+1;	
		$pageSize=$this->getPageSize();
		$startRecord=($currentPage-1)*$pageSize;
		$totalPage=$this->getPageCount();
		$totalRecord=$this->getItemCount();
		if($startRecord==0)
		{
			$startRecord=1;	
		}
		else
		{
			$startRecord=$startRecord+1;
		}
		
		if($currentPage==$totalPage)
		{
			$endRecord=$totalRecord;
		}
		else
		{
			$endRecord=$currentPage*$pageSize;
		}
		$buttons[1]='<li> '.$startRecord.' - '.$endRecord. ' of '.$totalRecord.' </li>';
		echo $this->header;
		echo CHtml::tag('ul',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
	}

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

		
		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]='<li> &nbsp; </li>';
		
		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
			if(strstr($class,'hidden'))
			{
				$class = str_replace(' ','-', $class);	
			}
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page).'&'.$this->extraPara).'</li>';
	}

}