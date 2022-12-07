var page = require('webpage').create();
var fs = require('fs');

page.viewportSize = {width: 1200, height: 800};


page.clipRect = {"width":1200,"height":800,"top":"100","left":"100"};




page.open('www.fb.com', function (status) {
    if (status !== 'success') {
        console.log('Unable to load the address!');
        phantom.exit(1);
    }

    
    page.evaluate(function() {
                    /* This will set the page background color */
            if (document && document.body) {
                document.body.bgColor = '#FFFFFF';
            }
        
            });

    setTimeout(function() {
            page.render('jozko.jpg');

                            fs.write('/home/martin/PhpstormProjects/screen/demo/assets/4195ba07baa67c42f1cdda90adff5474.json', JSON.stringify(phantom.cookies), "w");
            
            phantom.exit();
    }, 0);
});
