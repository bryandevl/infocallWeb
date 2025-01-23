'use strict';
const { useState } = React;
const appRoot = document.getElementById('match_dial_scoring_component');

const SERVER_SCORING = crScoringEndpoint;

const ScoringComponent = () => {
  const [data, setData] = useState([]);
  const [core, setCore] = useState('core1');
  const [listId, setListId] = useState('');

  return (
    <div className='container-fluid spark-screen'>
      <div className='row'>
        <div className='col-md-12'>
          <div className='row'>
            <div className='col-md-6 col-md-offset-3'>
              <MatchDialFilterComponent
                responseData={setData}
                responseCore={setCore}
                responseListId={setListId}
              />
            </div>
          </div>
          <div className='row'>
            <ScoringMatchDialTableComponent matchData={data} core={core} listId={listId} />
          </div>
        </div>
      </div>
    </div>
  );
};

const root = ReactDOM.createRoot(appRoot);
root.render(<ScoringComponent />);
