import json
import sys
import os
from google import genai
from google.genai import types

def generate_description(data):
    data = json.dumps(data)
    client = genai.Client(api_key=os.environ.get("GEMINI_API_KEY"))

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
    {data}
    """

    prompt = f"""Generate comprehensive medical description for {data['name']} following this structure.
    Additional instructions: {data.get('additional_instructions', '')}"""

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

    try:
        return json.loads(response.text)
    except json.JSONDecodeError:
        return {"error": "Failed to parse Gemini response"}

if __name__ == "__main__":
    try:
        input_json = json.loads(sys.argv[1])
        result = generate_description(input_json)
        print(json.dumps(result))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
