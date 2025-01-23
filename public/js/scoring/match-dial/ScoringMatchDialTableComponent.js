'use strict';

const { useEffect, useState, useRef } = React;

const ScoringMatchDialTableComponent = ({ matchData, core, listId }) => {
  const [data, setData] = useState([]);
  const tableRef = useRef();

  useEffect(() => {
    const configTable = {
      lengthMenu: [
        [5, 25, 50, 100, -1],
        [5, 25, 50, 100, 'Todos'],
      ],
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json',
      },
      data: data,
      columns: [
        { class: 'text-center text-uppercase', data: 'listId' },
        { class: 'text-center text-uppercase', data: 'leadId' },
        { class: 'text-center text-uppercase', data: 'vendorLeadCode' },
        { class: 'text-center text-uppercase', data: 'sourceId' },
        { class: 'text-center text-uppercase', data: 'phoneNumber' },
        { class: 'text-center text-uppercase', data: 'operator' },
        { class: 'text-center text-uppercase', data: 'score' },
        { class: 'text-center text-uppercase', data: 'rank' },
        { class: 'text-center text-uppercase', data: 'betterManagement' },
        { class: 'text-center text-uppercase', data: 'beastTry' },
        {
          class: 'text-center text-uppercase',
          data: 'withWhatsapp',
          render: (data) => (data ? 'Si' : 'No'),
        },
      ],
      destroy: true,
    };
    const table = $(tableRef.current).DataTable(configTable);
    return () => {
      table.destroy();
    };
  }, []);

  useEffect(() => {
    if (matchData.length > 0) {
      setData(matchData);
      $(tableRef.current).DataTable().clear().draw();
      $(tableRef.current).DataTable().rows.add(matchData).draw();
    }
  }, [matchData]);

  return (
    <div className='box'>
      <div className='box-header'>
        <h3 className='box-title'>Scoring</h3>
        <div className='box-tools'>
          {data.length > 0 && <ButtonVicidialExporterComponent core={core} listId={listId} />}
        </div>
      </div>
      <div className='box-body table-responsive'>
        <table className='table table-hover table-striped nowrap' ref={tableRef}>
          <thead>
            <tr>
              <th className='text-center'>List Id</th>
              <th className='text-center'>Lead Id</th>
              <th className='text-center'>DNI</th>
              <th className='text-center'>Cuenta</th>
              <th className='text-center'>Telefono</th>
              <th className='text-center'>Operador</th>
              <th className='text-center'>Score</th>
              <th className='text-center'>Prioridad</th>
              <th className='text-center'>Tipo contacto</th>
              <th className='text-center'>Mejor Intento</th>
              <th className='text-center'>Whatsapp</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  );
};
