#!/usr/bin/python

import paypalrestsdk
from paypalrestsdk import Order
from paypalrestsdk import Payment
from paypalrestsdk import ResourceNotFound
from paypalrestsdk.openid_connect import Tokeninfo

def order_find(order_id):
    try:
        order_info = Order.find(order_id)
        print info
    except ResourceNotFound as error:
        pass
    return order_info

def find_payment(payment_id):
    try:
        payment = Payment.find(payment_id)
    except ResourceNotFound as err:
        pass
    return payment
def openid_connect(client_id, client_secret, url, profile, authorize_code):
    paypalrestsdk.configure({ 'openid_client_id': client_id,
                              'openid_client_secret': client_secret,
                              'openid_redirect_uri': url })
    login_url = Tokeninfo.authorize_url({ 'scope': profile})
    tokeninfo = Tokeninfo.create(authorize_code)
    userinfo  = tokeninfo.userinfo()
    tokeninfo = tokeninfo.refresh()
    logout_url = tokeninfo.logout_url()

if __name__ == '__main__':
    '''
    for test
    '''
    print find_payment("PAY-0XL713371A312273YKE2GCNI")
    '''
    result save to DB.
    '''