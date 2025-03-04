import sys
from rembg import remove
from PIL import Image

def remove_bg(input_path, output_path):
    input_image = Image.open(input_path)
    output_image = remove(input_image)

    # Determine the file extension for optimization settings
    file_ext = output_path.split('.')[-1].lower()

    save_args = {}
    if file_ext == 'png':
        save_args['optimize'] = True
        save_args['compress_level'] = 9  # Max compression
    elif file_ext in ('jpg', 'jpeg'):
        # Handle transparency by adding white background
        if output_image.mode in ('RGBA', 'LA'):
            background = Image.new('RGB', output_image.size, (255, 255, 255))
            background.paste(output_image, mask=output_image.split()[-1])
            output_image = background
        save_args['optimize'] = True
        save_args['quality'] = 85  # Balanced quality and size
    elif file_ext == 'webp':
        save_args['quality'] = 80  # Adjust for quality vs size
        save_args['method'] = 6    # Slower compression for better results

    output_image.save(output_path, **save_args)

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python bg_remover.py <input_path> <output_path>")
        sys.exit(1)

    input_path = sys.argv[1]
    output_path = sys.argv[2]
    remove_bg(input_path, output_path)
