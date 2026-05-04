from pyautogui import *
import pyautogui
import time
import keyboard
import random
import win32api, win32con
from google import genai
import base64
import webbrowser

webbrowser.open("https://www.legabasket.it/calendario?selectedTeamId=all&selectedTab=schedule&year=2025&championshipTypeId=4&phaseToShow=all&matchDay=18")
time.sleep(5)
win32api.SetCursorPos((1919,205))
pyautogui.dragTo(1919, 283, duration=1, button='left')
im1 = pyautogui.screenshot(region=(174,307,780,675))
im1.save(r"./savedimage.png")

"""with open("./savedimage.png", "rb") as f:
    image_data = base64.b64encode(f.read()).decode("utf-8")

# Send to Gemini
client = genai.Client(api_key="AIzaSyC0NNw6zRRypV4Tul1QcMW85mMPniD6C2o")

response = client.models.generate_content(
    model="gemini-2.5-flash",
    contents=[
        {
            "parts": [
                {
                    "inline_data": {
                        "mime_type": "image/png",
                        "data": image_data
                    }
                },
                {
                    "text": (
                        "Look at this screenshot which contains tabular data. "
                        "Convert all the data you see into SQL INSERT INTO statements. "
                        "Infer the table name and column names from the headers if visible. "
                        "Return only the SQL statements, nothing else."
                    )
                }
            ]
        }
    ]
)

print(response.text)"""


