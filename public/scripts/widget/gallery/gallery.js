define(["dojo/_base/declare", "dojo/_base/array", "dojo/dom-construct", "dojo/query", "dojo/_base/lang", "dojo/on", "dojo/dom-class", "dojo/mouse", "dojo/fx", "dojo/dom-style", "dojo/dom",
	"dojo/topic", "dojo/dom-geometry",
        "dijit/_WidgetBase", "dijit/_OnDijitClickMixin", "dijit/_TemplatedMixin",
	"dojox/timing",
	"scripts/widget/gallery/popup",
	"dojo/text!./mainTemplate.html"
],
function(declare, array, domConstruct, query, lang, on, domClass, mouse, fx, domStyle, dom,
                 topic, domGeom,
		 _WidgetBase, _OnDijitClickMixin, _TemplatedMixin, 
		 timer,
		 galleryPopup,
		 template){

    return declare([_WidgetBase, _OnDijitClickMixin, _TemplatedMixin], {
	//	set our template
	templateString: template,

	//	some properties
	baseClass: "galleryWidget",
	title: "Image Gallery",

	sourceImages: [],
        currentKey: 0,
        sliding: false,
        slideSpeed: 6000,
	timer: null,
	
	postCreate: function() {
            this.init();
	},

	init: function() {
            this.pageSetup();
	},
        
	pageSetup: function() {
            this._addItems();                       
            this.setupPaginator();
	},
		
	_addItems: function() {
            array.forEach(this.sourceImages, lang.hitch(this, function(e, key){
                var btn = domConstruct.create("li", {class: "galleryImgBtn", innerHTML: ""}, this.galleryselectorNode);
                var img = domConstruct.create("li", {class: "galleryThumbnail", style: "left:"+(key*600)+"px;"}, this.galleryimgNode);
                domStyle.set(img, "background", "url('"+e.src+"')");
                domStyle.set(img, "backgroundSize", "contain");
                domStyle.set(img, "backgroundRepeat", "no-repeat");
                domStyle.set(img, "backgroundPosition", "center");
                if (2>query('li', this.galleryselectorNode).length){
                    domClass.add(btn, "selected");
                    domStyle.set(btn, "margin-left", "0px");
                }
				on(img, "click", lang.hitch(this, function(){
					var popup = new galleryPopup({img: e.src});
					popup.placeAt(this.galleryPopupNode);
									
					on.once(popup, "close", function(args){
						domConstruct.destroy(this.galleryPopupNode);
						popup.destroy();
					});
				}));
				
	    }));
            
            domStyle.set(this.galleryselectorNode, "width", (this.sourceImages.length*26)+"px");
	},
               
        setupPaginator: function() {
            var navBtns = query('li', this.galleryselectorNode);
            
            this.timer = null;
	    this.timer = new timer.Timer(this.slideSpeed);
	    this.timer.onTick = lang.hitch(this, function() {
                if (!this.sliding) {
                    domClass.remove(query('.selected', this.galleryselectorNode)[0], "selected");
                    if (this.currentKey >= (navBtns.length-1)) {
                        this.currentKey = this.slideHorizontal(0, this.currentKey, p2Slide);
                        domClass.add(navBtns[0], "selected");
                    } else {
                        domClass.add(navBtns[this.currentKey+1], "selected");
                        this.currentKey = this.slideHorizontal(this.currentKey+1, this.currentKey, p2Slide);
                    }
                }
	    });	
            var p2Slide = query('li', this.galleryimgNode);

            array.forEach(navBtns, lang.hitch(this,function (item, key){
                on(item, 'click', lang.hitch(this, function(){
                    if (!this.sliding) {
                        domClass.remove(query('.selected', this.galleryselectorNode)[0], "selected");
                        domClass.add(item, "selected");
                        this.timer.setInterval(this.slideSpeed);
                        this.currentKey = this.slideHorizontal(key, this.currentKey, p2Slide);
                    }
                }));
            }));
            
            this.timer.start();
//            
//            //cheating here to fix a dojo bug
//            domClass.remove(query('.selected', this.galleryselectorNode)[0], "selected");
//            domClass.add(navBtns[1], "selected");
//            this.currentKey = this.slideHorizontal(1, this.currentKey, p2Slide);
        },     
      
        slideHorizontal: function(key, current, pages, duration) {
            duration = typeof duration !== 'undefined' ? duration : 500;
            var difference = current - key;
            if (difference < 0){
                pages.reverse();
            }
            array.forEach(pages, lang.hitch(this,function (item, key){
                fx.slideTo({
                    duration: duration,
                    node: item,
                    left: (domGeom.getMarginBox(item).l + (difference*domGeom.getMarginBox(item).w)).toString(),
                    top: domGeom.getMarginBox(item).t.toString(),
                    units: "px",
                    onEnd: lang.hitch(this,function(){
                        this.sliding = false;
                    })
                }).play();
                this.sliding = true;
                
                
            }));
            return key;
        }
    });
});

