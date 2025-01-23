'use strict';

const { useEffect, useState, useRef } = React;

const ButtonVicidialExporterComponent = ({ core, listId }) => {
  const [loading, setLoading] = useState(false);
  const downloadFile = async () => {
    setLoading(true);
    await fetch(`${SERVER_SCORING}/exporter/vicidial/${core}/${listId}`, {
      method: 'GET',
      mode: 'cors',
    })
      .then((response) => response.blob())
      .then((blob) => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${core}_${listId}.csv`;
        document.body.appendChild(a);
        a.click();
        a.remove();
      });
    setLoading(false);
  };

  return (
    <button
      className='btn btn-success btn-flat btn-sm'
      disabled={loading}
      onClick={() => downloadFile()}
    >
      {loading && <i className='fa fa-refresh fa-spin'></i>}
      {!loading && <i className='fa fa-download'></i>}
    </button>
  );
};
