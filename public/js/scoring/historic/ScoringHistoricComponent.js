'use strict';
const { useEffect, useRef } = React;
const appRoot = document.getElementById('scoring_historic_component');

const SERVER_SCORING = 'http://192.168.1.6:3000';

const ScoringHistoricComponent = () => {
  const tableRef = useRef();

  useEffect(() => {
    const configTable = {
      lengthMenu: [
        [5, 25, 50, -1],
        [5, 25, 50, 'Todos'],
      ],
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json',
      },
      searching: false,
      ordering: false,
      bFilter: false,
      ajax: {
        url: `${SERVER_SCORING}/scoring/show-historic`,
        dataSrc: 'rows',
      },
      processing: true,
      serverSide: true,
      columns: [
        { class: 'text-center', data: 'period' },
        { class: 'text-center', data: 'raw.info' },
        { class: 'text-center', data: 'createdAt' },
        { class: 'text-center', data: null, render: () => {
          return `<button class='btn btn-primary btn-sm'><i class='fa fa-sync' ></i> Relaunch</button>`;
        } },
      ],
      destroy: true,
    };
    const table = $(tableRef.current).DataTable(configTable);
    return () => {
      table.destroy();
    };
  }, []);

  return (
    <div className='box'>
      <div className='box-header'>
        <h3 className='box-title'>Histórico de ejecuciones</h3>
      </div>
      <div className='box-body table-responsive-md'>
        <table className='table table-hover table-striped nowrap' ref={tableRef}>
          <thead>
            <tr>
              <th className='text-center'>Period</th>
              <th className='text-center'>Info</th>
              <th className='text-center'>Executed at</th>
              <th className='text-center'></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  );
};

const root = ReactDOM.createRoot(appRoot);
root.render(<ScoringHistoricComponent />);
