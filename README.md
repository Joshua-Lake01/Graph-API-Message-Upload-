# Graph-API-Message-Upload-
This is mostly just formatted to the way needed for this situation. This is for Facebook. It allows to input page access keys, data ect and we can thus get it to send a request through the tokens to facebook to upload a item. To get tokens/keys you must login with your account and create an app on the facebook developers website. And then generate a token through the graph API explorer.
This has two options, one is to upload a message and a URL and the other is to uplaod a message and a link. 
If you want option 1 you need to pass in the parameter $msgtype = 1 and for 2 $msgtype = 2.
This is ran server side only and will not be able to be ran on a client end. 
You MUST upload this to a FTP server of such.
