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

import pandas as pd
import requests
from io import StringIO
 
url = "https://www.legabasketfemminile.it/Calendar.aspx?ID=313"
 
session = requests.Session()
session.headers.update({"User-Agent": "Mozilla/5.0 Chrome/124.0.0.0"})
 
html = session.get(url).text
tabelle = pd.read_html(StringIO(html))  # StringIO risolve il problema di lettura
 
for i, df in enumerate(tabelle):
    print(f"--- Tabella {i} ---")
    print(df)

from playwright.sync_api import sync_playwright
import pandas as pd
from io import StringIO

with sync_playwright() as p:
    browser = p.chromium.launch()
    page = browser.new_page()
    page.goto("https://www.legabasketfemminile.it/Calendar.aspx?ID=313")
    page.wait_for_timeout(3000)  # aspetta che il JS carichi i dati
    html = page.content()
    browser.close()

tabelle = pd.read_html(StringIO(html))
for i, df in enumerate(tabelle):
    print(f"--- Tabella {i} ---")
    print(df)

print("File salvato: apri pagina.html nel browser o in un editor")

"""prompt = (
    "You are a SQL expert. I will give you:\n"
    "1. A screenshot containing match/game data in tabular form\n"
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
                    "text": prompt
                }
            ]
        }
    ]
)
print(response.text)"""
