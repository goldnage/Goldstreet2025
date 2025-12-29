from google.colab import userdata
import os

os.environ["OPENAI_API_KEY"] = userdata.get('OPENAI_API_KEY')

from openai import OpenAI
client = OpenAI()
def get_chat_gpt_response(prompt):
  response = client.chat.completions.create(
    model="gpt-3.5-turbo",
    messages=[{"role": "user", "content": prompt}],
    max_tokens=2048,
    temperature=0.7
  )
  return response.choices[0].message.content.strip()

prompt = "Explain the difference between symmetric and asymmetric encryption in Korean."
response_text = get_chat_gpt_response(prompt)
print(response_text)