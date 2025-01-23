'use strict';

const { useState } = React;

const ButtonDelete = ({ id, setRefresh }) => {
  const [deleting, setDeleting] = useState(false)
  const handleClick = async () => {
    setDeleting(true);
    const response = await fetch(`${SERVER_SCORING}/scoring/settings/fields/destroy/${id}`, {
      method: 'DELETE',
      mode: 'cors',
    }).then((response) => response.json());
    if (response.data.affected === 1) {
      setRefresh(true);
    }
    setDeleting(false);
  };

  return (
    <button type='button' className='btn btn-danger btn-xs' onClick={handleClick}>
      {
        deleting ? (<i className='fa fa-refresh fa-spin'></i>) :
          (<i className='fa fa-trash'></i>)
      }
    </button>
  );
};