# pip install requests
import os
import sys
import requests

base_url = "https://wow.zamimg.com/"
total_files = 0
current_file = 0
saved_files = 0
failed_files = 0

with open("armory_files.txt", "r") as in_file:
    if os.name == 'nt':
        os.system('cls')
        os.system("title retrieve_files.py")
    else:
        os.system('clear')
        sys.stdout.write("\x1b]2;retrieve_files.py\x07")
        sys.stdout.flush()

    files = in_file.readlines()
    total_files = len(files)
    for file in files:
        current_file += 1
        file_path = file.strip()
        file_url = base_url + file_path
        file_path = file_path.replace("modelviewer/wrath/", "public/asset/")
        file_path = file_path.replace("charactercustomization", "customization")
        file_path = file_path.replace("textures/", "texture/")
        file_path = file_path.replace("images/wow/icons/medium/", "public/img/icon/36x36/")
        response = requests.get(file_url)

        if response.status_code == 200:
            os.makedirs(os.path.dirname(file_path), exist_ok=True)
            with open(file_path, "wb") as save_file:
                save_file.write(response.content)
            saved_files += 1
            print(f"Retrieved {current_file}/{total_files}: {file_path}")
        else:
            failed_files += 1
            print(f"Failed {current_file}/{total_files}: {file_url}, reason: {response.status_code}")

print(f"Files retrieval completed.\n")
print(f"{saved_files}/{total_files} files retrieved!")
print(f"{failed_files}/{total_files} files failed!")
