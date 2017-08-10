<?php
namespace vendor\csl;

class Page
{
	protected $total = 1;    //总记录数
	protected $countOfPage;  //每页记录数
	protected $totalPage;    //总页数
	protected $page;         //当前页
	protected $url;

	/**
	 * 初始化对象
	 *
	 * @param      integer  $total  总记录数
	 * @param      integer  $count  每页记录数
	 */
	public function __construct($total,$count)
	{
		$this->total = $total < 1 ? $this->total :$total;
		$this->countOfPage = $count < 1? $this->countOfPage : $count;
		$this->totalPage = ceil($this->total/$this->countOfPage);
		$this->getPage();//获取当前页
		     
		$this->url = $this->getUrl();//url不带page参数
	}

	/**
	 * 获取首页的url
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function first()
	{
		return $this->setUrl(1);
	}

	public function last()
	{
		return $this->setUrl($this->totalPage);
	}

	public function next()
	{
		if ($this->page >= $this->totalPage) {
			return $this->setUrl($this->totalPage);
		}

		return $this->setUrl($this->page + 1);
	}

	public function pre()
	{
		if ($this->page <=1) {
			return $this->first();
		}
		return $this->setUrl($this->page - 1);
	}

	public function limit()
	{
		$offset = ($this->page - 1) * $this->countOfPage;
		return ' ' . $offset . "," . $this->countOfPage;
	}

	public function page()
	{
		return ''.$this->page.','.$this->countOfPage;
	}

	public function allPage()
	{
		return [
		'first' =>$this->first(),
		'pre'   =>$this->pre(),
		'next'  =>$this->next(),
		'last'  =>$this->last()
		];
	}

	/**
	 * [basePaging 基本分页]
	 * @return [type] [description]
	 */
	public function basePaging()
	{
		$str  = "<ul class='pagination'><li><a href='";
		$str .= $this->first()."'>首页</a></li> <li><a href='";
		$str .= $this->pre()  ."'>上一页</a></li><li><a href='";
		$str .= $this->next() ."'>下一页</a></li><li><a href='";
		$str .= $this->last() ."'>尾页</a></li></ul>";
		return  $str;
	}


	/**
	 * 拼接url
	 *
	 * @param      <type>  $page   页数
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	protected function setUrl($page)
	{
		//判断url中是否有？
		//http://localhost/1707/hight/5/Page.php?page=1
		if (stripos($this->url,'?')) {
			return $this->url . "&page=".$page;
		} else {
			return $this->url . "?page=".$page;
		}
	}
	protected function getUrl()
	{
		$url = $_SERVER['REQUEST_SCHEME'] .'://';//获取协议
		$url .= $_SERVER['HTTP_HOST']; //拼接主机地址
		$url .= ':' . $_SERVER['SERVER_PORT'];//拼接端口                    
		$data = parse_url($_SERVER['REQUEST_URI']);
		$url .= $data['path'];//拼接路径
		if (!empty($data['query'])) {
			parse_str($data['query'],$paras);//获取查询参数，然后放到$paras数组中
			unset($paras['page']);//销毁page元素
			$url .= '?' . http_build_query($paras);        
			
		}
		$url = rtrim($url,'?');//干掉最后一个问号
		return $url;                                           
	}
	
	/**
	 * 获取当前页数
	 */
	protected function getPage()
	{
		//如果url中没有page
		if (empty($_GET['page'])) {
			$this->page = 1;
		}else{
			$page = $_GET['page'];
			if($page < 2){
				$this->page = 1;
			}else if($page > $this->totalPage){
				$this->page = $this->totalPage;
			}else{
				$this->page = $page;
			}
		}
	}
}

