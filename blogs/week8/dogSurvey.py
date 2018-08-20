import json
import requests
import random
from PIL import Image
from PIL import ImageFont
from PIL import ImageDraw
from urllib.request import urlopen # must be python3
# from urllib2 import urlopen # for python2

# PART 1: GATHER ONE RESPONSE
# Create the dictionary to store the responses.
answers = {}

# Create a list of survey questions and a list of related keys that will be used when storing survey results.
survey = [
    "What is your name?",
    "How old are you?",
    "What is your hometown?",
    "What is your date of birth? (DD/MM/YYYY)"]
keys = ["name", "age", "hometown", "DOB"]

# Iterate over the list of survey questions and take in user responses.
def take_survey():
    for x in range(len(survey)):
        response = input(survey[x] +": ")
        answers[keys[x]] = response
    return answers # changed it from printing to returning the answers

# Return random dog picture url
def by_breed(breed):
    url = "https://dog.ceo/api/breed/"
    r = requests.get(url + breed + "/images")
    d = r.json()
    dog_address = d['message']
    random_num = random.randint(0,len(dog_address)-1)
    return dog_address[random_num]

# Show an edited picture given url
def show_pic(url, name):
    print("Based on your survey results, your are this kind of dog")
    img =Image.open(urlopen(url))
    draw = ImageDraw.Draw(img)
    # font = ImageFont.truetype(<font-file>, <font-size>)
    font = ImageFont.truetype('/Library/Fonts/Comic Sans MS Bold.ttf', 80)
    # draw.text((x, y),"Sample Text",(r,g,b))
    draw.text((30,10), name,(255,255,255), font = font)
    img.show(draw)

# PART 2: GATHER MULTIPLE RESPONSES
done = False
all_answers = []
while done == False:
    this_survey = take_survey()
    all_answers.append(this_survey)
    print(this_survey["name"])
    show_pic(by_breed("pug"), this_survey["name"])
    response = input("Type '1' to administer another survey and anything else to exit. ")
    if response != "1" :
        done = True

print(all_answers)

# PART 3: SAVE RESPONSES

# # Open the file containing all past results and append them to our current list.
# f = open("surveyResponses.json", "r")
# olddata = json.load(f)
# list_of_answers.extend(olddata)
# f.close()
#
# # Reopen the file in write mode and write each entry in json format.
# f = open("allanswers.json", "w")
# f.write('[\n')
# index = 0
# for t in list_of_answers:
#     if (index < len(list_of_answers)-1):
#         json.dump(t, f)
#         f.write(',\n')
#     else:
#         json.dump(t, f)
#         f.write('\n')
#     index += 1
#
# f.write(']')
# f.close()

# PART 4: ANALYZE THE DATA
