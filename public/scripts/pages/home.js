require(["dojo/ready", "dojo/dom", "dojo/dom-class",
		 "scripts/widget/gallery/gallery"
		],
function(ready, dom, domClass,
		 gallery) 
{	
	var images = [{src: "../../../content/img/pages/home/gallery/6.jpg"},
		      {src: "../../../content/img/pages/home/gallery/4.jpg"},
		      {src: "../../../content/img/pages/home/gallery/3.jpg"},
		      {src: "../../../content/img/pages/home/gallery/1.jpg"},
		      {src: "../../../content/img/pages/home/gallery/2.jpg"}]
	ready(function(){
		domClass.add(dom.byId("pageloading"), "hidden");
		domClass.remove(dom.byId("content"), "hidden");
		
		var imgGallery = new gallery({ sourceImages: images });
		imgGallery.placeAt(dom.byId("gallery"));
	});
});
