# pip install pillow
import glob
import os
import sys
from PIL import Image, ImageFile
ImageFile.LOAD_TRUNCATED_IMAGES = True

converted_files = 0

if os.name == 'nt':
    os.system('cls')
    os.system("title convert_images.py")
else:
    os.system('clear')
    sys.stdout.write("\x1b]2;convert_images.py\x07")
    sys.stdout.flush()

for f in glob.glob("public/img/icon/36x36/*.jpg"):
    file, extension = os.path.splitext(f)
    file = file.replace("\\", "/")
    image = Image.open(f).convert("RGBA")
    image.save(file + ".webp", format="webp", quality=100, lossless=True)
    os.remove(f)
    converted_files += 1
    print(f"Converted {file}.webp")

for f in glob.glob("public/asset/texture/*.png"):
    file, extension = os.path.splitext(f)
    file = file.replace("\\", "/")
    image = Image.open(f).convert("RGBA")
    image.save(file + ".webp", format="webp", quality=100, lossless=True)
    os.remove(f)
    converted_files += 1
    print(f"Converted {file}.webp")

print(f"Images conversion completed.\n")
print(f"{converted_files} images converted!")