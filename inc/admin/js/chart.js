
// set the dimensions and margins of the graph
const margin = {top: 10, right: 30, bottom: 30, left: 60},
    width = 700 - margin.left - margin.right,
    height = 400 - margin.top - margin.bottom;

// append the svg object to the body of the page
const svg = d3.select('#mittpwa_installations')
  .append('svg')
    .attr('width', width + margin.left + margin.right)
    .attr('height', height + margin.top + margin.bottom)
  .append('g')
    .attr('transform',
          'translate(' + margin.left + ',' + margin.top + ')');


//Read the data

const getInstallStatistic = {
    task: 'getInstallationStatistic'
}

d3.json('index.php?option=com_ajax&plugin=MittPwaPush&format=json', {
            method: 'POST',
            mode: 'same-origin',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(getInstallStatistic)   
        })
        
   .then(data => {
          const dataObject = JSON.parse(data.data[0])
          let countChrome = 0
          let countIos = 0
          let day
          let dayBefore
          const newDataObject = dataObject.map(d => {
              countChrome = countChrome + parseInt(d.chrome)
              countIos = countIos + parseInt(d.ios)

              day = new Date(d.installed_at).toISOString().split('T')[0]
              const object = {
                  ios: d.ios,
                  chrome: d.chrome,
                  installed_at: day
              }
              return object

          })


          function groupBy(objectArray, property) {
              return objectArray.reduce(function(acc, obj) {
                  var key = obj[property];
                  if (!acc[key]) {
                      acc[key] = [];
                  }
                  acc[key].push(obj);
                  return acc;
              }, {});
          }

          const groupedInstallDate = groupBy(newDataObject, 'installed_at')

          const dateKeys = Object.keys(groupedInstallDate);
          const typeKeys = ['ios', 'chrome'];
          const colors = {
            'ios': '#4287f5',
            'chrome': '#f54257'
          }


          const finalData = typeKeys.map((key) => {
            const values = dateKeys.map((date) => {
              const counts = groupedInstallDate[date].reduce((a, b) => {
                return a + parseInt(b[key]);
              }, 0)
              return {
                installed_at: date,
                count: counts
              }
            })
            return {
              key: key,
              values: values
            }
          })


          const statistic = newDataObject.reduce((accumulator, data) => {
              if (accumulator[data.ios]) {
                  accumulator[data.ios] = accumulator[data.ios] + 1
              } else {
                  accumulator[data.ios] = 1
              }
              return accumulator
          }, )


         const line =  d3.line()
         .x(d => {
             return x(new Date(d.installed_at))
         })
         .y(d => {
             return y(d.count)
         })

          const chromeSpan = document.createElement('span')
          const iOsSpan = document.createElement('span')
          chromeSpan.style.color = colors['chrome']
          iOsSpan.style.color = colors['ios']
          chromeSpan.textContent = `\u00A0${countChrome}`
          iOsSpan.textContent = `\u00A0${countIos}`
          const totalInstallContainer = document.querySelector('.mittpwa_totalinstall')
          const chromeInstallations = totalInstallContainer.querySelector('.chrome')
          chromeInstallations.style.display = 'flex'
          const iOsInstallations = totalInstallContainer.querySelector('.ios')
          iOsInstallations.style.display = 'flex'
          chromeInstallations.appendChild(chromeSpan)
          iOsInstallations.appendChild(iOsSpan)


          const x = d3.scaleTime()
              //.label('Installations')
              .domain(d3.extent(dataObject, d => {
                  return new Date(d.installed_at);
              }))
              .range([0, width]).nice();
          svg.append("g")
              .attr("transform", "translate(0," + height + ")")
              .call(d3.axisBottom(x));

          //Add Y axis
          const y = d3.scaleLinear()
              .domain([
                d3.min(finalData, d => d3.min(d.values, c => c.count)),
                d3.max(finalData, d => d3.max(d.values, c => c.count))
              ])
              .range([height, 0]);
          svg.append("g")
              .call(d3.axisLeft(y));

          // // Add the line
          svg.selectAll(".install")
              .data(finalData)
              .enter().append('path').attr('class', 'install')
              .attr("fill", "none")
              .attr("stroke", (d) => colors[d.key])
              .attr("stroke-width", 1.5)
              .attr("d", (d) =>  line(d.values))

   })
  
