import argparse
import os
from PIL import Image

def compress_image(input_path, output_path, quality=85, resize_factor=1.0):
    try:
        with Image.open(input_path) as img:
            # Resize image if needed
            if resize_factor != 1.0:
                new_size = tuple(max(1, int(dim * resize_factor)) for dim in img.size)
                img = img.resize(new_size, Image.LANCZOS)

            # Create output directory if needed
            os.makedirs(os.path.dirname(output_path), exist_ok=True)

            # Get output format from extension
            ext = os.path.splitext(output_path)[1].lower()

            save_args = {'optimize': True}

            if ext in ('.jpg', '.jpeg'):
                save_args['quality'] = max(1, min(95, quality))
                save_args['progressive'] = True
            elif ext == '.png':
                save_args['compress_level'] = max(0, min(9, quality // 10))
            elif ext == '.webp':
                save_args['quality'] = max(0, min(100, quality))
                save_args['method'] = 4
            else:
                raise ValueError(f"Unsupported format: {ext}. Use .jpg/.jpeg, .png, or .webp")

            img.save(output_path, **save_args)
            print(f"Compressed image saved to {output_path} ({os.path.getsize(output_path)//1024} KB)")

    except Exception as e:
        print(f"Error: {str(e)}")

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Advanced Image Compressor")
    parser.add_argument("input", help="Input image path")
    parser.add_argument("output", help="Output image path (with extension)")
    parser.add_argument("-q", "--quality", type=int, default=85,
                        help="Quality (1-95 JPG, 0-9 PNG via q//10, 0-100 WebP)")
    parser.add_argument("-r", "--resize-factor", type=float, default=1.0,
                        help="Resize multiplier (0.1-1.0)")

    args = parser.parse_args()
    compress_image(args.input, args.output, args.quality, args.resize_factor)
