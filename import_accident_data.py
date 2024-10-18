import pandas as pd

# Google DriveのファイルIDを指定
file_id = '1deZvD_R2TLP1qOmB0snxUaDkUMkotnfh'
url = 'https://docs.google.com/spreadsheets/d/1deZvD_R2TLP1qOmB0snxUaDkUMkotnfh/export?format=csv}'

# pandasでGoogle Sheetsの内容を読み込む
df = pd.read_csv(url)

# データを確認
print(df.head())