import json
import operator

with open("water.json") as json_file:
	json_data = json.load(json_file)
	
	# print "Json =" ,json_data


	def sth(key):
		print key
		try:
			return float(key["water"])
		except(KeyError,ValueError):
			print "No data"


	b = sorted(json_data[:-1], key=sth ,reverse= True)


	print b	
	json = json.dumps(b)
	f = open("water1.json", "w")
	#f.write("district,population")
	f.write(json)
	f.close()
