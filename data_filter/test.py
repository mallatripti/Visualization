#!/usr/bin/env python
import json
import os
import csv
import random
import string
import sys


currentdirpath = os.getcwd()
filename = 'choices.csv'
file_path = os.path.join(os.getcwd(), filename)

def get_file_path(filename):
	currentdirpath = os.getcwd
	file_path = os.path.join(os.getcwd(),filename)
	print file_path
	return file_path

path = get_file_path('choices.csv')
info=[{}]

def read_csv(filepath):
	with open(filepath, 'rU') as csvfile:
		reader = csv.reader(csvfile)
		i=0
		for row in reader:
			if "Water Coverage Supply (%)"in row:
				print row[0],row[2]
				info[i]["district"]=row[0]
				info[i]["water"]=row[2]
				# print datadict
				info.append({})
				i+=1
				# print info

				#print info
		return info


a=json.dumps(read_csv(path))

# print a

f= open("water.json","w")
f.write(a)
f.close()
		
arg=sys.argv[1:]
try:
    f=open(arg[0],'rU')
    all=f.read()
    sth=all.replace(" {", "\n{")
    sth=sth.replace(" :{", ":\n{")
    sth=sth.replace(" [", ":\n[")
    sth=sth.replace(",\"", ",\n\"")
    sth=sth.replace(":[", ":\n[")


    f.close()
    f=open(arg[0],'w')
    f.write(sth)
    f.close()
except IndexError:
    print "--usage: \n \t python insertls.py <some json file>"



