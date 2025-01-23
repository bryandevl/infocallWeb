'use strict';
const { useState, useEffect } = React;

const ScoringPanelConfigComponent = ({ setRefresh, campaign }) => {
  const [loading, setLoading] = useState(false);
  const [data, setData] = useState([]);
  const [database, setDatabase] = useState([]);
  const [table, setTable] = useState([]);
  const [valuesCondition, setValuesCondition] = useState([]);
  const [fields, setFields] = useState([]);

  const [databaseSelected, setDatabaseSelected] = useState('');
  const [tableSelected, setTableSelected] = useState('');
  const [fieldSelected, setFieldSelected] = useState('');
  const [conditionSelected, setConditionSelected] = useState('');
  const [valueConditionSelected, setValueConditionSelected] = useState('');
  const [scoringValue, setScoringValue] = useState('');

  const getFields = async () => {
    setLoading(true);
    await fetch(`${SERVER_SCORING}/scoring/settings/fields/get-fields`, {
      method: 'GET',
      mode: 'cors',
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then((response) => {
        setData(response);
        const responseDatabase = response.map((item) => item.database);
        setDatabase([...new Set(responseDatabase)]);
      })
      .catch((error) => {
        console.error('There has been a problem with your fetch operation:', error);
      });
    setLoading(false);
  };

  const getValuesCondition = async () => {
    setValuesCondition([]);
    await fetch(`${SERVER_SCORING}/scoring/settings/fields/get-distinct-values`, {
      method: 'POST',
      mode: 'cors',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        table: tableSelected,
        field: fieldSelected,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then((response) => {
        setValuesCondition(response);
      })
      .catch((error) => {
        console.error('There has been a problem with your fetch operation:', error);
      });
  };

  useEffect(() => {
    const getData = async () => {
      await getFields();
    };
    getData();
  }, []);

  useEffect(() => {
    if (databaseSelected) {
      setTable([]);
      setFields([]);
      setTableSelected('');
      setFieldSelected('');
      setScoringValue(0);
      setConditionSelected('');
      setValueConditionSelected('');
      const responseTable = data
        .filter((item) => item.database === databaseSelected)
        .map((item) => item.table);
      setTable([...new Set(responseTable)]);
    }
  }, [databaseSelected]);

  useEffect(() => {
    if (tableSelected) {
      setFields([]);
      setFieldSelected('');
      setScoringValue(0);
      setConditionSelected('');
      setValueConditionSelected('');
      const responseField = data
        .filter((item) => item.table === tableSelected)
        .map((item) => item.field);
      setFields(responseField);
    }
  }, [tableSelected]);

  useEffect(() => {
    if (fieldSelected) {
      setScoringValue(0);
      setConditionSelected('');
      setValueConditionSelected('');
      const getData = async () => {
        setLoading(true);
        await getValuesCondition();
        setLoading(false);
      };
      getData();
    }
  }, [fieldSelected]);

  const handlerSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    await fetch(`${SERVER_SCORING}/scoring/settings/fields/save`, {
      method: 'POST',
      mode: 'cors',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        campaign,
        database: databaseSelected,
        table: tableSelected,
        field: fieldSelected,
        condition: conditionSelected,
        valueCondition: valueConditionSelected,
        valueScore: scoringValue,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then((response) => {
        setDatabaseSelected('');
        setTableSelected('');
        setFieldSelected('');
        setTable([]);
        setFields([]);
        setConditionSelected('');
        setValueConditionSelected('');
        setValuesCondition([]);
        setScoringValue(0);
        setRefresh(true);
      })
      .catch((error) => {
        console.error('There has been a problem with your fetch operation:', error);
      });
    setLoading(false);
  };

  return (
    <div className='box box-success box-solid'>
      <div className='box-header with-border'>
        <h3 className='box-title'>New settings</h3>
      </div>
      <div className='box-body'>
        <form onSubmit={handlerSubmit}>
          <div className='form-group row'>
            <div className='col-md-2'>
              <label htmlFor='database'>Database</label>
              <select
                className='form-control'
                id='database'
                name='database'
                value={databaseSelected}
                required
                onChange={(e) => setDatabaseSelected(e.target.value)}
              >
                <option value=''>Select a option</option>
                {database.map((item) => (
                  <option key={item} value={item}>
                    {`${item}`.toUpperCase()}
                  </option>
                ))}
              </select>
            </div>
            <div className='col-md-2'>
              <label htmlFor='table'>Table</label>
              <select
                className='form-control'
                id='table'
                name='table'
                value={tableSelected}
                required
                onChange={(e) => setTableSelected(e.target.value)}
              >
                <option value=''>Select a option</option>
                {table.map((item) => (
                  <option key={item} value={item}>
                    {`${item}`.toUpperCase()}
                  </option>
                ))}
              </select>
            </div>
            <div className='col-md-2'>
              <label htmlFor='field'>Fields</label>
              <select
                className='form-control'
                id='field'
                name='field'
                value={fieldSelected}
                required
                onChange={(e) => setFieldSelected(e.target.value)}
              >
                <option value=''>Select a option</option>
                {fields.map((item) => (
                  <option key={item} value={item}>
                    {`${item}`.toUpperCase()}
                  </option>
                ))}
              </select>
            </div>
            <div className='col-md-2'>
              <label htmlFor='condition'>Condition</label>
              <select
                className='form-control'
                id='condition'
                name='condition'
                value={conditionSelected}
                required
                onChange={(e) => setConditionSelected(e.target.value)}
              >
                <option value=''>Select a option</option>
                <option value='='> Igual </option>
                <option value='<'> Menor que </option>
                <option value='>'> Mayor que </option>
                <option value='!='> Diferente </option>
              </select>
            </div>
            <div className='col-md-2'>
              <label htmlFor='valueCondition'>Value Condition</label>
              <select
                className='form-control'
                id='valueCondition'
                name='valueCondition'
                value={valueConditionSelected}
                required
                onChange={(e) => setValueConditionSelected(e.target.value)}
              >
                <option value=''>Select a option</option>
                {valuesCondition.map((item, index) => (
                  <option key={index} value={item.value}>
                    {`${item.value}`.toUpperCase()}
                  </option>
                ))}
              </select>
            </div>
            <div className='col-md-2'>
              <label htmlFor='valueScore'>Value Score</label>
              <div className='input-group'>
                <input
                  type='number'
                  name='valueScore'
                  id='valueScore'
                  placeholder='ej. 10'
                  className='form-control'
                  value={scoringValue}
                  required
                  onChange={(e) => setScoringValue(e.target.value)}
                />
                <span className='input-group-btn'>
                  <button className='btn btn-primary btn-flat' type='submit'>
                    Add
                  </button>
                </span>
              </div>
            </div>
          </div>
        </form>
      </div>
      {loading && (
        <div className='overlay'>
          <i className='fa fa-refresh fa-spin'></i>
        </div>
      )}
    </div>
  );
};
