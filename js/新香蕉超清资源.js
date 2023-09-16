var rule = {
    title:'新香蕉超清资源',
    host:'https://52kkpp.vip/cq',
	//searchUrl:'/cn/search/**',
    url:'/fyclass-fypage.html',
    headers:{
        'User-Agent':'MOBILE_UA'
    },
    timeout:5000,
    class_name:'亚洲AV',//静态分类名称拼接
    class_url:'2k-yazhou',//静态分类标识拼接
    limit:5,
    play_parse:true,
    lazy:'',
    一级:'.list-videos&&.item;.title&&Text;img&&data-original;.duration&&Text;a&&href',
    二级:'*',
//	搜索:'.grid.grid-cols-2 div&&a;.lozad.w-full&&alt;.lozad.w-full&&data-src;.absolute.bottom-1&&Text;a&&href',
	  searchable:1,//是否启用全局搜索,
    quickSearch:1,//是否启用快速搜索,
    filterable:0,//是否启用分类筛选,
}
