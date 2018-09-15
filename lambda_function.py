from random import randint

def lambda_handler(event, context):

    endSession = True
    sa = {}

    if event["request"]["type"] == "LaunchRequest":
        output_speech_text = "Hello World"

    elif event["request"]["type"] == "IntentRequest":
        if event["request"]["intent"]["name"] == "AMAZON.HelpIntent":
            output_speech_text = "I'm sorry, you are on your own."

        elif event["request"]["intent"]["name"] == "RandomNumber":
            if "value" in event["request"]["intent"]["slots"]["low"]:
                low = event["request"]["intent"]["slots"]["low"]["value"]
            else:
                low = 1
            if "value" in event["request"]["intent"]["slots"]["high"]:
                high = event["request"]["intent"]["slots"]["high"]["value"]
            else:
                high = 11
            if low == "?":
                randomNum = int(high)
            elif high == "?":
                randomNum = int(low)
            else:
                randomNum = randint(int(low), int(high))
            output_speech_text = "{0}".format(randomNum)

        elif event["request"]["intent"]["name"] == "Arithmetic":
            sa["operation"] = event["request"]["intent"]["slots"]["operation"]["value"]
            if "value" in event["request"]["intent"]["slots"]["numberOne"]:
                numberOne = event["request"]["intent"]["slots"]["numberOne"]["value"]
                if numberOne == "?":
                    output_speech_text = "I didn't get your first number. What was it?"
                    endSession = False
                else:
                    sa["numberOne"] = numberOne

            if "value" in event["request"]["intent"]["slots"]["numberTwo"]:
                numberTwo = event["request"]["intent"]["slots"]["numberTwo"]["value"]
                if numberTwo == "?":
                    output_speech_text = "I didn't get your second number. What was it?"
                    endSession = False
                else:
                    sa["numberTwo"] = numberTwo

            if numberOne != "?" and numberTwo != "?":
                if event["request"]["intent"]["slots"]["operation"]["value"] == "add":
                    added = int(numberOne) + int(numberTwo)
                    output_speech_text =  "{0}".format(added)
                elif event["request"]["intent"]["slots"]["operation"]["value"] == "multiply":
                    multiplied = int(numberOne) * int(numberTwo)
                    output_speech_text =  "{0}".format(multiplied)


        elif event["request"]["intent"]["name"] == "Answer":
            answer = event["request"]["intent"]["slots"]["number"]["value"]
            if "attributes" in event["session"] and "numberOne" in event["session"]["attributes"]:
                previous = event["session"]["attributes"]["numberOne"]
            elif "attributes" in event["session"] and "numberTwo" in event["session"]["attributes"]:
                previous = event["session"]["attributes"]["numberTwo"]

            if "attributes" in event["session"] and "operation" in event["session"]["attributes"]:
                if event["session"]["attributes"]["operation"] == "add":
                    added = int(answer) + int(previous)
                    output_speech_text =  "{0}".format(added)
                elif event["session"]["attributes"]["operation"] == "multiply":
                    multiplied = int(answer) * int(previous)
                    output_speech_text =  "{0}".format(multiplied)

    output_speech_object = {"type": "PlainText", "text": output_speech_text}
    response_object = {"outputSpeech": output_speech_object, "shouldEndSession": endSession}
    response = {"version": "1.0", "response": response_object, "sessionAttributes":sa}
    return response
