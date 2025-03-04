import sys
import os
from google import genai
from google.generai import types
from prompt.description_prompt import prompt

client = genai.GenerativeModel(model_name="gemini-pro", api_key=os.environ.get("GEMINI_API_KEY"))

def generate_description(data, prompt=None):
    if(prompt == None):
        prompt = get_desription_prompt(data)

    prompt_text = data
    try:
        response = client.generate_content(
            model="gemini-pro", # using gemini-pro for better structured output
            contents=[
                {"role": "user", "parts": [{"text": prompt_text}]},
            ],
            generation_config={
                "temperature": 0.2, # Lower temperature for more consistent, structured output
                "top_p": 0.95,
                "top_k": 40,
                "max_output_tokens": 8192,
            },
            safety_settings={
                "HARASSMENT": "block_none",
                "HATE_SPEECH": "block_none",
                "SEXUALLY_EXPLICIT": "block_none",
                "DANGEROUS_CONTENT": "block_none",
            },
            system_instruction=system_instruction_text,
        )


        print(response.text)

    except Exception as e:
        print("Error generating description: {str(e)}")

def get_desription_prompt(data):
    system_prompt = prompt
    return


if __name__ == "__main__":
    if len(sys.argv) != 1:
        print("Usage: python bg_remover.py <input_path> <output_path>")
        sys.exit(1)

    input_path = sys.argv[1]
    remove_bg(data)
