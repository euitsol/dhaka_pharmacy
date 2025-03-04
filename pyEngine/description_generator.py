import json
import sys
import os
import logging
from datetime import datetime
from google import genai
from google.genai import types

# Configure logging
def setup_logger():
    # Create logs directory inside pyEngine folder
    log_dir = os.path.join(os.path.dirname(__file__), 'logs')
    if not os.path.exists(log_dir):
        os.makedirs(log_dir, exist_ok=True)

    # Create a logger
    logger = logging.getLogger('description_generator')
    logger.setLevel(logging.DEBUG)

    # Create handlers
    log_file = os.path.join(log_dir, f'description_generator-{datetime.now().strftime("%Y-%m-%d")}.log')
    file_handler = logging.FileHandler(log_file)
    console_handler = logging.StreamHandler()

    # Create formatters
    formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
    file_handler.setFormatter(formatter)
    console_handler.setFormatter(formatter)

    # Add handlers to logger
    logger.addHandler(file_handler)
    logger.addHandler(console_handler)

    return logger

# Initialize logger
logger = setup_logger()

def generate_description(data):
    logger.info(f"Starting description generation for: {data.get('name', 'Unknown')}")
    data_str = json.dumps(data)
    try:
        client = genai.Client(api_key="AIzaSyAzAEt6GcxKUjn3CJiSbOVypx7UBvLpOnc")
        logger.info("Successfully initialized Gemini client")

        model = "gemini-1.5-pro-latest"
        system_instruction = """You are a medical information system. Generate structured JSON responses with these exact keys:
        {
            "introduction": "",
            "indication": "",
            "how_to_use": "",
            "pharmacology": "",
            "administration_dosage": {
                "adult_dose": "",
                "child_dose": "",
                "others_dose": ""
            },
            "mode_of_action": "",
            "interaction": "",
            "contraindication": "",
            "precaution_warnings": "",
            "pregnancy_lactation": "",
            "side_effects": "",
            "storage": ""
        }
        Use the following parameters:
        {data_str}
        """

        prompt = f"""Generate comprehensive medical description for {data['name']} following this structure.
        Additional instructions: {data.get('additional_instructions', '')}"""

        logger.info(f"Sending request to Gemini API for: {data.get('name', 'Unknown')}")
        response = client.generate_content(
            model=model,
            contents=[types.Content(parts=[types.Part.from_text(prompt)])],
            generation_config=types.GenerationConfig(
                temperature=0.2,
                top_p=0.95,
                top_k=40,
                max_output_tokens=8192,
                response_mime_type="application/json",
            ),
            safety_settings={
                    "HARASSMENT": "block_none",
                    "HATE_SPEECH": "block_none",
                    "SEXUALLY_EXPLICIT": "block_none",
                    "DANGEROUS_CONTENT": "block_none",
            },
            system_instruction=types.Content(parts=[types.Part.from_text(system_instruction.format(**data))])
        )
        logger.info(f"Received response from Gemini API for: {data.get('name', 'Unknown')}")

        try:
            logger.debug(f"Raw response: {response.text}")
            result = json.loads(response.text)
            logger.info(f"Successfully parsed JSON response for: {data.get('name', 'Unknown')}")
            return result
        except json.JSONDecodeError as e:
            logger.error(f"Failed to parse Gemini response: {e}")
            logger.debug(f"Raw response that failed parsing: {response.text}")
            return {"error": "Failed to parse Gemini response"}
    except Exception as e:
        logger.error(f"Error during description generation: {str(e)}")
        return {"error": str(e)}

if __name__ == "__main__":
    try:
        logger.info("Script started via command line")
        input_json = json.loads(sys.argv[1])
        logger.info(f"Processing input for: {input_json.get('name', 'Unknown')}")
        result = generate_description(input_json)
        print(json.dumps(result))
        logger.info("Script completed successfully")
    except Exception as e:
        logger.error(f"Script failed with error: {str(e)}")
        print(json.dumps({"error": str(e)}))
