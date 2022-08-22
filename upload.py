import requests
import os
import sys
import json

# ---Configs---
api_url='http://192.168.31.2/img/update.php' #API URL
api_key='5grAtvQ0v5Ktq73TmaRM' #API KEY



    


#上传文件
def upload_file(file_path):

    #获取后缀名
    file_suffix = os.path.splitext(file_path)[1][1:]

    payload={'key': api_key}
    files=[
    ('file',('file',open(file_path,'rb'),'image/'+file_suffix))
    ]
    headers = {}

    response = requests.request("POST", api_url, headers=headers, data=payload, files=files)


    if response.status_code==200:
        return(response.text)
    else:
        print(response.text)
        return('error')




argv_num=len(sys.argv)-1
i=0
urls=[]

# {"success":true,"result":["http://192.168.31.2/img/amg81a05a77ed3179f9fa113c39d655efe7.png","http://192.168.31.2/img/amg3486aeed4a0fe046534eddcdad1b9cb9.png"]}
while i<argv_num:

    info=upload_file(sys.argv[i+1])

    if(info=='error'):
        print(json.dumps({"success":False,"result":{}}))
        exit()
        
    
    else:
        url=json.loads(info)['file_url']
        urls.append(url)
    
    i=i+1

# i=0
# url_num=len(urls)
# while i<url_num:
#     urls[i]
#     i=i+1

print(json.dumps({"success":True,"result":urls}))



