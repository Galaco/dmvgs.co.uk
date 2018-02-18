define(["dojo/_base/declare", "dojo/dom-construct", "dojo/_base/lang", "dojo/on", "dojo/Evented", "dojo/dom-style",
	"dojo/window",
        "dijit/_WidgetBase", "dijit/_OnDijitClickMixin", "dijit/_TemplatedMixin",
	"dojo/text!./popupTemplate.html"
],
function(declare, domConstruct, lang, on, Evented, domStyle,
         Window,
	 _WidgetBase, _OnDijitClickMixin, _TemplatedMixin,
	 template){

    return declare([_WidgetBase, _OnDijitClickMixin, _TemplatedMixin, Evented], {
	//	set our template
	templateString: template,

	//	some properties
	baseClass: "galleryWidget",
	title: "Image Gallery",

	img: [],
	
	postCreate: function() {
            this.init();
	},

	init: function() {
            this.pageSetup();
	},

	pageSetup: function() {
            on(this.exitButtonNode, "click", lang.hitch(this, function(){
                this.emit("close");
            }));
            
            var image = domConstruct.create("img", {src: this.img});
            domStyle.set(this.mainImageNode, "background", "url("+this.img+") 50% 50% / contain no-repeat");
            
            var vs = Window.getBox();
            domStyle.set(this.mainPopup, "width", image.width+"px");
            domStyle.set(this.mainPopup, "height", image.height+"px");
            domStyle.set(this.mainPopup, "margin-left", -(image.width/2)+"px");
            domStyle.set(this.mainPopup, "margin-top", -(image.height/2)+"px");
//            domStyle.set(this.mainPopup, "max-width", vs.w*0.9+"px");
//            domStyle.set(this.mainPopup, "max-height", vs.h*0.9+"px");
            if ( vs.h < image.height || vs.w < image.width) { 
                domStyle.set(this.mainPopup, "max-height", vs.h*0.9+"px");
                domStyle.set(this.mainPopup, "max-width", vs.w*0.9+"px");
                domStyle.set(this.mainPopup, "margin-left", -(vs.w*0.45)+"px");
                domStyle.set(this.mainPopup, "margin-top", -(vs.h*0.45)+"px");
            }
			
            on(this.popupNode, "click", lang.hitch(this, function(e){
				if(e.target == this.popupNode){
					this.emit("close");
				}
            }));
	}
    });
});

