function New() {
  return (
    <>
      <h1>Nueva nota</h1>
      <form>
        <label htmlFor='title'>Título:</label>
        <input type='text' placeholder='titulo' id='value' />
        <div className='editor'></div>
        <button>Enviar</button>
      </form>
    </>
  )
}

export default New
