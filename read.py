import os
import pandas as pd
import mysql.connector

def load_data_from_csv(file_path):
    df = pd.read_csv(file_path).dropna()
    return df

def insert_data_to_mysql(df):
    try:
        conn = mysql.connector.connect(
            host="127.0.0.1",
            user=os.environ['DB_USER'],
            password=os.environ['DB_PASSWORD'],
            database="your_database"
        )
        cursor = conn.cursor()

        cursor.execute("""
            CREATE TABLE IF NOT EXISTS safety_data (
                id INT AUTO_INCREMENT PRIMARY KEY,
                columnA VARCHAR(255),
                columnB VARCHAR(255),
                columnC VARCHAR(255),
                columnD VARCHAR(255),
                columnE VARCHAR(255),
                columnF VARCHAR(255),
                columnG VARCHAR(255),
                columnH VARCHAR(255),
                columnI VARCHAR(255),
                columnJ VARCHAR(255),
                columnK VARCHAR(255),
                columnL VARCHAR(255),
                columnM VARCHAR(255)
            )
        """)

        rows_to_insert = [
            (
                row['ColumnA'], row['ColumnB'], row['ColumnC'], row['ColumnD'], row['ColumnE'],
                row['ColumnF'], row['ColumnG'], row['ColumnH'], row['ColumnI'], row['ColumnJ'],
                row['ColumnK'], row['ColumnL'], row['ColumnM']
            )
            for _, row in df.iterrows()
        ]
        

        cursor.executemany("""
            INSERT INTO safety_data (columnA, columnB, columnC, columnD, columnE, columnF, columnG, columnH, columnI, columnJ, columnK, columnL, columnM)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """, rows_to_insert)
        
        conn.commit()
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

# データの読み込みと挿入
df_non_empty = load_data_from_csv('001721757.csv')
insert_data_to_mysql(df_non_empty)
