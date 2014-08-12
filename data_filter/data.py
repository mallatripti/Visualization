#!/usr/bin/env python
import json
import os
import csv
import random
import string


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
			if "Total Population"in row:
				print row[0],row[2]
				info[i]["district"]=row[0]
				info[i]["population"]=row[2]
				info.append({})
				i+=1

				# print info
		return info


a=json.dumps(read_csv(path))

# print a

f= open("tripti.json","w")
f.write(a)
f.close()
		



