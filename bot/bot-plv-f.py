from pyautogui import *
import pyautogui
import time
import keyboard
import random
import win32api, win32con
from google import genai
import base64
import webbrowser
import os
from os.path import join, dirname
from dotenv import load_dotenv

dotenv_path = os.path.join(os.path.dirname(__file__), '..', '.env')
load_dotenv(dotenv_path)
api_key = os.environ.get("GEMINI_API_KEY")

webbrowser.open("https://www.legavolleyfemminile.it/risultati/?serie=1&campionato=710324&stagione=2025&giornata=713227")
time.sleep(3)
win32api.SetCursorPos((1910, 179))
pyautogui.dragTo(1910, 271, duration=1, button='left')
im1 = pyautogui.screenshot(region=(150, 202, 700, 803))
im1.save(r"./savedimage.png")
time.sleep(2)
pyautogui.dragTo(1910, 436, duration=1, button='left')
im1 = pyautogui.screenshot(region=(150, 202, 700, 803))
im1.save(r"./savedimage1.png")
time.sleep(2)
pyautogui.dragTo(1910, 607, duration=1, button='left')
im1 = pyautogui.screenshot(region=(150, 207, 700, 212))
im1.save(r"./savedimage2.png")

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

with open(os.path.join(BASE_DIR, "savedimage.png"), "rb") as f:
    image_data = base64.b64encode(f.read()).decode("utf-8")

with open(os.path.join(BASE_DIR, "savedimage1.png"), "rb") as f:
    image_data1 = base64.b64encode(f.read()).decode("utf-8")

with open(os.path.join(BASE_DIR, "savedimage2.png"), "rb") as f:
    image_data2 = base64.b64encode(f.read()).decode("utf-8")

with open(os.path.join(BASE_DIR, "squadra.sql"), "r", encoding="utf-8") as f:
    squadra_sql = f.read()

with open(os.path.join(BASE_DIR, "risultato.sql"), "r", encoding="utf-8") as f:
    risultato_sql = f.read()

prompt = (
    "You are a SQL expert. I will give you:\n"
    "1. three screenshots containing match/game data in tabular form\n"
    "2. Two SQL table definitions with their existing data (squadra and risultato)\n\n"
    "Your task:\n"
    "- Read the data visible in the screenshot\n"
    "- Generate valid INSERT INTO statements for the `risultato` table based on what you see\n"
    "- Use the `squadra` table to match team names to their correct `id` values\n"
    "- Follow exactly this column order: (id, id_squadra1, id_squadra2, punteggio_sq1, punteggio_sq2, vincitore)\n"
    "- `vincitore` must be the id of the winning team (the one with the higher score)\n"
    "- Use IDs that continue from the last existing one in risultato\n"
    "- Return ONLY the SQL INSERT INTO statements, no explanation, no markdown\n\n"
    "Here is the squadra table (team names -> IDs):\n"
    + squadra_sql +
    "\nHere is the risultato table (for context on existing data and ID continuation):\n"
    + risultato_sql
)
time.sleep(3)
api_key = os.environ.get("GEMINI_API_KEY")
client = genai.Client(api_key=api_key)
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
                    "inline_data": {
                        "mime_type": "image/png",
                        "data": image_data1
                    }
                },
                {
                    "inline_data": {
                        "mime_type": "image/png",
                        "data": image_data2
                    }
                },
                {
                    "text": prompt
                }
            ]
        }
    ]
)
print(response.text)
