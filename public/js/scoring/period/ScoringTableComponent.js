'use strict';

const { useEffect, useState, useRef } = React;

const ScoringTableComponent = ({ scoringData, scoringParams }) => {
  const [data, setData] = useState([]);
  const [saving, setSaving] = useState(false);
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
        { class: 'text-center text-uppercase', data: 'phoneNumber' },
        { class: 'text-center text-uppercase', data: 'score' },
        { class: 'text-center text-uppercase', data: 'operator.operator' },
        { class: 'text-center text-uppercase', data: 'betterManagement' },
        { class: 'text-center text-uppercase', data: 'betterManagementDate' },
        {
          class: 'text-center text-uppercase',
          data: 'operator.withWhatsapp',
          render: (data) => {
            return data ? 'Si' : 'No';
          },
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
    if (scoringData.length > 0) {
      setData(scoringData);
      $(tableRef.current).DataTable().clear().draw();
      $(tableRef.current).DataTable().rows.add(scoringData).draw();
    }
  }, [scoringData]);

  const saveData = async () => {
    setSaving(true);
    await fetch(`${SERVER_SCORING}/scoring/save`, {
      method: 'POST',
      mode: 'cors',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(scoringParams),
    })
      .then((response) => response.json())
      .catch((error) => {
        console.log(error);
        setSaving(false);
      });
    setSaving(false);
  };

  return (
    <div className='box'>
      <div className='box-header'>
        <h3 className='box-title'>Scoring</h3>
        <div className='box-tools'>
          {data.length > 0 && (
            <button className='btn btn-success btn-flat btn-sm' onClick={() => saveData()}>
              Guardar resultados
            </button>
          )}
        </div>
      </div>
      <div className='box-body table-responsive-md'>
        <table className='table table-hover table-striped nowrap' ref={tableRef}>
          <thead>
            <tr>
              <th className='text-center'>Phone Number</th>
              <th className='text-center'>Score</th>
              <th className='text-center'>Operator</th>
              <th className='text-center'>Beast Management</th>
              <th className='text-center'>Beast Date</th>
              <th className='text-center'>With Whatsapp</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      {saving && (
        <div className='overlay'>
          <i className='fa fa-refresh fa-spin'></i>
        </div>
      )}
    </div>
  );
};
