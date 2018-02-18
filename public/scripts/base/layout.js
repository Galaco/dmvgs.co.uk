require(["dojo/ready", "dojo/dom-class"
		 ],
function(ready, domClass) {
	
    //When DOM is ready
    ready(function(){
	    domClass.add("pageloading", "hidden");
	    domClass.remove("content", "hidden");
    });
});
