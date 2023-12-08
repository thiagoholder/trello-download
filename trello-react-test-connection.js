import React, { useState } from 'react';
import axios from 'axios';


function App() {
  const [apiKey, setApiKey] = useState('');
  const [token, setToken] = useState('');
  const [message, setMessage] = useState('')

  const testConnection = async () => {
    try {
        const response = await axios.get(`https://api.trello.com/1/members/me/boards?key=${apiKey}&token=${token}`);
        if (response.status === 200) {
            setMessage('Conexão com o Trello bem-sucedida!');
        } else {
            setMessage('Falha na conexão.');
        }
    } catch (error) {
        setMessage('Erro na conexão.');
    }
};

  return (
    <div className="App">
      <div>
            <input type="text" value={apiKey} onChange={e => setApiKey(e.target.value)} placeholder="API Key" />
            <input type="text" value={token} onChange={e => setToken(e.target.value)} placeholder="Token" />
            <button onClick={testConnection}>Testar Conexão</button>
            <p>{message}</p>
        </div>
    </div>
  );
}

export default App;
