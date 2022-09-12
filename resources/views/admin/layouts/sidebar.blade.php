<!-- begin:: Aside -->
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

	<!-- begin:: Aside -->
	<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
		<div class="kt-aside__brand-logo">
			<a href="{{ url('/admin/dashboard') }}">
				<!--<img alt="Logo" src="{{ asset('admin/assets/media/logos/logo-12.png')}}">-->
				SSMK APPS - ADMIN
			</a>
		</div>
		<div class="kt-aside__brand-tools">
			<button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler"><span></span></button>
		</div>
	</div>

	<!-- end:: Aside -->

	<!-- begin:: Aside Menu -->
	<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
		<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
			<ul class="kt-menu__nav ">
				<?php
				$results = DB::table('menus')->where(['menus.deleted' => 0])->leftJoin('rights','menus.right_id','=','rights.id')->leftJoin('menu_types','menu_types.id','=','menus.menu_type_id')->where('menu_types.id','=',1)->where('menus.status','=',1)->select('menus.*','rights.routes')->groupBy('menus.id')->orderBy('menus.parent_id')->orderBy('menus.ordering')->get();
				if(isset($results) && !empty($results)){
					foreach($results as $keyRes => $valRes){
						$menuCategory['categories'][$valRes->id] = $valRes; 
						$menuCategory['parent_cats'][$valRes->parent_id][] = $valRes->id; 
					}	
				}
				function getCategories($parent, $menuCategory,$i) 
				{
					$activeClass = $html = "";
					if (isset($menuCategory['parent_cats'][$parent]))
					{
						foreach ($menuCategory['parent_cats'][$parent] as $key_id => $cat_id)
						{
							if (!isset($menuCategory['parent_cats'][$cat_id]))
							{
								if($parent != 0 && $key_id == 0){
									$html .= "<div class='kt-menu__submenu '><span class='kt-menu__arrow'> </span><ul class='kt-menu__subnav '>";
								}
								if(in_array($menuCategory['categories'][$cat_id]->routes,Session::get('routes'))){
									if(isset($menuCategory['categories'][$cat_id]->routes) && !empty($menuCategory['categories'][$cat_id]->routes)){
										$activeClass = "";
										if($menuCategory['categories'][$cat_id]->routes == "/".Request()->path()){
											$activeClass = " kt-menu__item--active ";
										}
										if($parent == 0){
											$html .= "<li class='kt-menu__item  ".$activeClass." ' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'><a class='kt-menu__link kt-menu__toggle' href='".$menuCategory['categories'][$cat_id]->routes."'> <i class='kt-menu__link-icon ".$menuCategory['categories'][$cat_id]->icon."'></i><span class='kt-menu__link-text'>".$menuCategory['categories'][$cat_id]->name."</span></a></li>";
										}else{
											$html .= "<li class='kt-menu__item kt-menu__item--submenu  ".$activeClass." ' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'><a class='kt-menu__link kt-menu__toggle' href='".$menuCategory['categories'][$cat_id]->routes."'> <i class='kt-menu__link-icon ".$menuCategory['categories'][$cat_id]->icon."'></i><span class='kt-menu__link-text'>".$menuCategory['categories'][$cat_id]->name."</span></a></li>";
										}
									}else{
										$html .= "<li class='kt-menu__item  kt-menu__item--submenu' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'><a class='kt-menu__link kt-menu__toggle' href='javascript:void(0);' aria-expanded='false' > <i class='".$menuCategory['categories'][$cat_id]->icon."'></i><span class='kt-menu__link-text'>".$menuCategory['categories'][$cat_id]->name."</span></a></li>";
									}
								}
								if($parent != 0 && ($key_id+1) == count($menuCategory['parent_cats'][$parent])){
									$html .= "</ul></div>";
								}
							}
							if (isset($menuCategory['parent_cats'][$cat_id]))
							{
								if(isset($menuCategory['categories'][$cat_id]->routes) && in_array($menuCategory['categories'][$cat_id]->routes,Session::get('routes'))){
									if(isset($menuCategory['categories'][$cat_id]->routes) && !empty($menuCategory['categories'][$cat_id]->routes)){
										$html .= "<li class='kt-menu__item  kt-menu__item--submenu' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'><a class='kt-menu__link kt-menu__toggle' href='".$menuCategory['categories'][$cat_id]->routes."' > <i class='kt-menu__link-icon ".$menuCategory['categories'][$cat_id]->icon."'></i><span class='kt-menu__link-text'>".$menuCategory['categories'][$cat_id]->name."</span></a>";
									}else{
										$html .= "<li class='kt-menu__item  kt-menu__item--submenu' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'><a class='kt-menu__link kt-menu__toggle' href='javascript:void(0);' > <i class='kt-menu__link-icon ".$menuCategory['categories'][$cat_id]->icon."'></i><span class='kt-menu__link-text'>".$menuCategory['categories'][$cat_id]->name."</span></a>";	
									}
								}else{
									if(isset($menuCategory['categories'][$cat_id]->routes) && !empty($menuCategory['categories'][$cat_id]->routes)){
										$html .= "<li class='kt-menu__item  kt-menu__item--submenu' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'><a class='kt-menu__link kt-menu__toggle ' href='".$menuCategory['categories'][$cat_id]->routes."' > <i class='kt-menu__link-icon ".$menuCategory['categories'][$cat_id]->icon."'></i><span class='kt-menu__link-text'>".$menuCategory['categories'][$cat_id]->name."</span></a>";
									}else{
										if(Session::get('role') != '3') {
											$html .= "<li class='kt-menu__item  kt-menu__item--submenu' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'><a class='kt-menu__link kt-menu__toggle ' href='javascript:void(0);' > <i class='kt-menu__link-icon ".$menuCategory['categories'][$cat_id]->icon."'></i><span class='kt-menu__link-text'>".$menuCategory['categories'][$cat_id]->name."</span><i class='kt-menu__ver-arrow la la-angle-right'></i></a>";	
										}
										
									}
								}
								$html .= getCategories($cat_id, $menuCategory,$i);
								$html .= "</li>";
							}
							$i++;
						}
					}
					return $html;
				}
				echo $data['category'] = getCategories(0, $menuCategory,0);
				?>
			</ul>
		</div>
	</div>

	<!-- end:: Aside Menu -->
</div>

