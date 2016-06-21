import os
import sys
class FtpImageFile(object):
    def __init__(self,product_id,path):
        """ Constructor call """

        self.product_id = product_id
        self.path = path

    def get_directory_structure(self,path):
        """ Get Ftp All Image Names and Folder Structure """

        content = ""
        for path, dirs, files in os.walk(path+str("/ftp")):
            content += str(path)+":"+str(files)+str("\n")
        return content

    def write_to_file(self,path,content):
        """ Write to Files with file name as  product_id+ftp.txt inside folder product_id """

        f = open(path,"w+")
        f.write(content)
        f.close()

product_id = sys.argv[1]
path = cpath = str(sys.argv[2])+str(product_id)
ftp = FtpImageFile(product_id,path)
content = ftp.get_directory_structure(path)
ftp.write_to_file(cpath+str("/")+str(product_id)+"_ftp.txt",content)
