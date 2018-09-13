#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Wed Jun  6 15:59:59 2018

@author: kristentang
"""

from PyQt5.QtWidgets import QApplication, QWidget, QLineEdit, QLabel
from PyQt5.QtCore import QTimer 
import socket

class ChatBox(QWidget): 
    
    def __init__(self): 
        super(ChatBox, self).__init__()
        self.initUI()
        self.socket()

        
    def initUI(self): 
        self.setGeometry(100,100,300,200)
        self.setWindowTitle("ChatBox")
        
        self.type_box = QLineEdit(self)
        self.type_box.move(50,50) # moves it relative to self
        self.type_box.setFixedWidth(200)
        self.type_box.returnPressed.connect(self.sendText)
        
        self.text_box = QLabel(self)
        self.text_box.move(50, 100)
        self.text_box.setFixedWidth(200)
        self.text_box.sizeHint()
        
        self.t = QTimer()
        self.t.start(2000)
        self.t.timeout.connect(self.recieveText) 
        
        self.show()
  
        
    def recieveText(self): 
        self.s.settimeout(.25)
        try: 
            self.received_data = self.s.recv(1000)
            if self.received_data == "": 
                self.text_box.setText("<connection lost>")
            else: 
                self.text_box.setText(self.received_data)
        except: 
            pass
        

    def sendText(self):
        self.text = self.type_box.text()
        self.s.send(self.text)
        self.type_box.setText("")
    
    
    def socket(self):
        self.port = 5000
        try : #client
            self.client() 
    
        except: #server 
            self.server()
           
            
    def client(self): 
        self.s = socket.socket()
#        self.s.connect(("128.97.12.102", self.port)) # from computer 1
#        self.s.connect(("128.97.12.103", self.port)) # from computer 2
        self.s.connect(("127.0.0.1", self.port)) # send message to your own computer 
        self.text_box.setText("<connected>")
        self.sendText()


    def server(self): 
        self.s = socket.socket()
        self.s.bind(("", self.port))
        self.s.listen(1)
        self.s, self.addr = self.s.accept() 
        self.text_box.setText("<connected>")
        self.sendText()  
        
        
    def closeEvent(self,e):
        self.sendText()
        self.s.close() 


def main(): 
    app = QApplication([])
    c = ChatBox()
    app.exec_()


if __name__ == '__main__':
    main()





    
    
    
"""
1. Start the GUI 
2. a - Try to be a client, b - be the server # PUT THIS IN A SEPARATE THREAD 
3. Every 2 seconds, recieve messages for .25 seconds # PUT THIS IN A SEPARATE THREAD (or same thread as ^)
    - when recv is happening nothing else can happen because computer can only do one thin at a time
4. 

"""
    

