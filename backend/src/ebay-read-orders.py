#!/usr/bin/python

from ebaysdk.finding import Connection as Finding
from ebaysdk.exception import ConnectionError
from ebaysdk.trading import Connection as Trading
from datetime import datetime
from datetime import timedelta
import ast
import MySQLdb
from types import *

DBCONNECTION = MySQLdb.connect("localhost", "root", "2doiouxi", "mss")
cursor = DBCONNECTION.cursor()

def getOrders():
    try:
        api = Trading(domain='api.ebay.com', 
                      debug=True, config_file='ebay.yaml',
                      warnings=True, timeout=20)
        res = api.execute('GetOrders', {
            'CreateTimeFrom': datetime.now() - timedelta(days=1),
            'CreateTimeTo': datetime.now(),
            #'OrderRole': 'Buyer',
            #'OrderStatus': 'Completed',
            })
        response = res.dict()
        print response
        #dump(api, full=False)
    except ConnectionError as e:
        print e
        print e.response.dict()

def getTokenStatus():
    result = False
    try:
        api = Trading(debug=False, config_file='ebay.yaml', 
                      domain='api.sandbox.ebay.com',
                      warnings=False)

        res = api.execute('GetTokenStatus')
        result = res.dict()
        print result
    except ConnectionError as e:
        print(e)
        print(e.response.dict())
        result = False
    return result

def checkTokenValid():
    res = False
    response = getTokenStatus()
    if response['Ack'] == "Success":
        tokenStatus = response['TokenStatus']['Status']
        expirationTime = datetime.strptime(response['TokenStatus']['ExpirationTime'], 
                                                    "%Y-%m-%dT%H:%M:%S.%fZ")
        res = ((expirationTime - datetime.now()) > timedelta(hours = 1))
    elif response['Ack'] == "Failure":
        errorCode = response['Errors']['ErrorCode']
        errorMessage = response['Errors']['LongMessage']
        res = False
    else:
        pass
    return res

def getToken():
    pass

def isExists(OrderID):
    sql = "SELECT COUNT(OrderID) AS len FROM orderlist WHERE OrderID='%s'" % OrderID
    cursor.execute(sql)
    rows = cursor.fetchall()
    res = False
    if len(rows) > 0:
        res = int(rows[0][0]) > 0
    return res

def addOrder(OrderDetail):
    print OrderDetail
    sql = "INSERT INTO orderlist () Values ()"

if __name__ == '__main__':
    #getOrders()
    '''
    #isExists(OrderID = '181223693749-1220220446008') # 
    '''
    with open('orders.txt', 'r') as f:
        line = f.readline()
        records = ast.literal_eval(line)
        orders = records['OrderArray']['Order']
        if type(orders) is DictType:
            print "OrderID:%s" % orders['OrderID']
            if isExists(orders['OrderID']) is False:
                addOrder(orders)
        elif type(orders) is ListType:
            print "ListType"
        #orders = records['OrderArray']['Order']
        #print orders
        '''
        for order in orders:
            print isExists(order['OrderID'])
        '''
