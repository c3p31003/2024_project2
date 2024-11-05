from flask import Flask, jsonify
import mysql.connector

app = Flask(__name__)

# データベースからデータを取得する関数
def fetch_data():
    conn = mysql.connector.connect(
        host="127.0.0.1",
        user="#",
        password="#",
        database="accident"
    )
    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT * FROM safety_data")
    rows = cursor.fetchall()
    cursor.close()
    conn.close()
    return rows

# WebAPIエンドポイント
@app.route('/api/data', methods=['GET'])
def get_data():
    data = fetch_data()
    return jsonify(data)

if __name__ == '__main__':
    app.run(debug=True)
