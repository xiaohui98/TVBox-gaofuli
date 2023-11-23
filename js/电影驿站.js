var rule={
            title: '电影驿站',
            host: 'https://www.dyyzb.com',
            url:'/vodtype/fyclass.html',
          //https://chinaqtv.co/vodsearch/.html?wd=4
            searchUrl: '/vodsearch/-------------.html?wd=**',    
            searchable: 2,//是否启用全局搜索,
            quickSearch: 0,//是否启用快速搜索,
            filterable: 0,//是否启用分类筛选,
            headers:{'User-Agent':'MOBILE_UA'},
            class_name:'电影&连续剧&综艺&动漫&短剧',//静态分类名称拼接
            class_url:'1&2&3&4&49',//静态分类标识拼接
            play_parse: true,
            lazy: '',
            limit: 6,  
          //推荐: 'body&&.content;div.drama;*;*;*;*',
          double:true,
          一级: '.slide-a&&.swiper-slide;.slide-info-title&&Text;.mask-1&&style;.slide-info-remarks&&Text;a&&href',
          二级: {
                "title": ".player-title-link&&Text",
                "content": ".card-text&&Text",
                "tabs": ".vod-playerUrl&&Text",//解析源
                "lists": ".select-a&&ul&&li"
            },
 }
