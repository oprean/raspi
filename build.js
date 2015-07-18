({
    mainConfigFile : "js/main.js",
    baseUrl: "js",
    removeCombined: true,
    findNestedDependencies: true,
    dir: "dist",
    //optimize: "none",
    modules: [
        {
            name: "main",
            exclude: [
				"infrastructure",
            ]
        },
        /*{
            name: "infrastructure"
        }*/
        
    ],
    paths: {
		"globals": "empty:" 
    }
})

 /*rmDir = function(dirPath) {
 	var fs = require("fs");
	var path = __dirname +'\\'+ dirPath;
	try { 
		var files = fs.readdirSync(path);
		console.log(files);
	} catch(e) { return; }
		if (files.length > 0) {
			for (var i = 0; i < files.length; i++) {
				var filePath = dirPath + '/' + files[i];
				if (fs.statSync(filePath).isFile())
					fs.unlinkSync(filePath);
				else
					rmDir(filePath);
    		}			
		}
	fs.rmdirSync(dirPath);
};

rmDir('dist\\templates');
*/