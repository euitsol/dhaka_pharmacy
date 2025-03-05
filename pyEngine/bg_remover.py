import sys
from rembg import remove
from PIL import Image

def remove_bg(input_path, output_path):
    input_image = Image.open(input_path)
    output_image = remove(input_image)
    output_image.save(output_path)

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python bg_remover.py <input_path> <output_path>")
        sys.exit(1)

    input_path = sys.argv[1]
    output_path = sys.argv[2]
    remove_bg(input_path, output_path)
