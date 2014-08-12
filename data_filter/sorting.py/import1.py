import json
import operator

with open("tripti.json") as json_file:
	json_data = json.load(json_file)
	
	#print(json_data)


	def sth(key):
		return int(key["population"])



	b = sorted(json_data[:-1], key=sth ,reverse= True)

	print b	
	json = json.dumps(b)
	f = open("tripti1.json", "w")
	#f.write("district,population")
	f.write(json)
	f.close()
