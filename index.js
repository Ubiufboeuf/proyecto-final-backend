import express from 'express'
import { writeFileSync, readFileSync } from 'node:fs'

const app = express()
const PORT = process.env.PORT ?? 1234

app.use((req, res, next) => {
  res.setHeader('Access-Control-Allow-Origin', '*'); // Allow any origin
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); // Allow these methods
  res.setHeader('Access-Control-Allow-Headers', '*'); // Allow these headers (add any custom headers your frontend sends)

  // Handle preflight OPTIONS requests
  if (req.method === 'OPTIONS') {
    res.sendStatus(200); // Respond with 200 OK for preflight
  } else {
    next();
  }
});

app.get('/', (req, res) => {
  console.log('get')
  res.sendStatus(200)
})

app.post('/', async (req, res) => {
  const promise = new Promise((resolve) => {
    let body = ''
    req.on('data', (chunk) => {
      body += chunk
    })
    
    req.on('end', () => {
      body.toString()
      resolve(body)
    })
  })

  const body = await promise
  console.log('body: ', body)

  const data = readFileSync('data.json', 'utf8')
  console.log({data})

  let savedJson
  if (data) {
    try {
      savedJson = JSON.parse(data)
    } catch (err) {
      console.error('Error, json guardado inválido: ', err)
      return
    }
  }
  console.log({json: savedJson})

  let bodyJson
  try {
    bodyJson = JSON.parse(body)
  } catch (err) {
    console.error('Error, json inválido: ', err)
    return
  }

  let newJson = [
    bodyJson
  ]
  if (data) {
    newJson = [
      ...savedJson,
      bodyJson
    ]
  }
  console.log(newJson)
  writeFileSync('data.json', JSON.stringify(newJson, null, 2), { encoding: 'utf8' })
  
  res.send('aceptado')
})

app.listen(PORT, () => console.log(`Servidor en el puerto: ${PORT}`))