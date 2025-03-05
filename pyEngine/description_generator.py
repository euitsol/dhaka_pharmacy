import json
import sys
import os
import logging
import re
from datetime import datetime
from google import genai
from google.genai import types
from description_prompt import system_prompt

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

def extract_json_from_text(text):
    """
    Extract JSON from text that may be wrapped in code blocks.
    This handles responses where JSON is wrapped in ```json and ``` markers.
    """
    # Check if the text contains JSON code blocks
    json_pattern = r'```json\s*(.*?)\s*```'
    match = re.search(json_pattern, text, re.DOTALL)

    if match:
        # Extract the JSON content from within the code blocks
        json_text = match.group(1)
        try:
            return json.loads(json_text)
        except json.JSONDecodeError as e:
            logger.error(f"Failed to parse JSON from code block: {e}")
            return {"error": "Failed to parse JSON from code block"}

    # If no code blocks, try to parse the entire text as JSON
    try:
        return json.loads(text)
    except json.JSONDecodeError as e:
        logger.error(f"Failed to parse text as JSON: {e}")
        return {"error": "Failed to parse text as JSON"}

def generate_description(data):
    logger.info(f"Starting description generation for: {data.get('name', 'Unknown')}")
    # Add debug logging for input data
    logger.debug(f"Input data: {json.dumps(data, indent=2)}")

    # data_str = json.dumps(data)
    try:
        client = genai.Client(api_key="AIzaSyDdoiiotmeT8IzukoCPmtFpinBsBGr-xCs")
        logger.info("Successfully initialized Gemini client")

        model = "gemini-2.0-flash"

        prompt = f"""
        generate descripton based on these Information:

        Product Name: {data.get('name', 'Not Provided')}
        Generic Name: {data.get('generic_name', 'Not Provided')}
        Strength: {data.get('strength', 'Not Provided')}
        Category: {data.get('category', 'Not Provided')}
        Sub Category: {data.get('sub_category', 'Not Provided')}
        Manufacturer: {data.get('company_name', 'Not Provided')}
        """.strip()

        logger.debug(f"User prompt: {prompt}")

        contents = [
            types.Content(
                role="user",
                parts=[
                    types.Part.from_text(
                        text=prompt
                    ),
                ],
            ),
        ]
        # Debug the system instruction
        # logger.debug(f"System instruction: {system_prompt}")

        logger.info(f"Sending request to Gemini API for: {data.get('name', 'Unknown')}")

        # Debug the request parameters
        logger.debug(f"Request parameters: model={model}, temperature=0.2, top_p=0.95, top_k=40, max_output_tokens=8192")

        # Updated API call to match the 0.3.1 version format
        response = client.models.generate_content(
            model=model,
            contents=contents,
            config= types.GenerateContentConfig(
                temperature=.1,
                top_p=0.95,
                top_k=40,
                max_output_tokens=8192,
                response_mime_type="text/plain",
                system_instruction=system_prompt,
                tools=[
                    types.Tool(
                        google_search=types.GoogleSearch()
                    )
                ]
            )
        )

        try:
            # More detailed debug of the raw response
            logger.debug(f"Raw response: {response.text}")
            logger.info(f"Successfully parsed JSON response for: {data.get('name', 'Unknown')}")

            return extract_json_from_text(response.text)
        except json.JSONDecodeError as e:
            logger.error(f"Failed to parse Gemini response: {e}")
            logger.debug(f"Raw response that failed parsing: {response.text}")
            return {"error": "Failed to parse Gemini response"}
    except Exception as e:
        logger.error(f"Error during description generation: {str(e)}")
        # Add stack trace for better debugging
        import traceback
        logger.debug(f"Exception traceback: {traceback.format_exc()}")
        return {"error": str(e)}

if __name__ == "__main__":
    try:
        logger.info("Script started via command line")
        # Debug command line arguments
        logger.debug(f"Command line arguments: {sys.argv}")

        input_json = json.loads(sys.argv[1])
        logger.info(f"Processing input for: {input_json.get('name', 'Unknown')}")
        # Debug the parsed input JSON
        logger.debug(f"Parsed input JSON: {json.dumps(input_json, indent=2)}")

        result = generate_description(input_json)
        # Debug the final result
        logger.debug(f"Final result: {json.dumps(result)}")

        # Print the result for the calling process
        print(json.dumps(result))

    except Exception as e:
        logger.error(f"Script failed with error: {str(e)}")
        # Add stack trace for better debugging
        import traceback
        logger.debug(f"Exception traceback: {traceback.format_exc()}")
        print(json.dumps({"error": str(e)}))
