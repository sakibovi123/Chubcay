import{r as t,j as e}from"./app-BPVxtKKl.js";function o({error:r}){const[s,n]=t.useState(3);return t.useEffect(()=>{const c=setInterval(()=>{n(i=>i-1)},1e3),l=setTimeout(()=>{window.location.href="/"},3e3);return()=>{clearInterval(c),clearTimeout(l)}},[]),e.jsx("div",{className:"container mx-auto h-full w-full",children:e.jsx("div",{className:"flex flex-col items-center justify-center gap-5",children:e.jsxs("div",{className:"w-[35%] bg-white p-[5rem] my-[12rem]",children:[e.jsx("h2",{className:"text-4xl text-center font-bold",children:"FAILED"}),e.jsx("p",{className:"text-center text-red-600 font-bold text-lg my-5",children:r}),e.jsxs("a",{className:`text-center bg-blue-600 p-2 my-5\r
             flex items-center justify-center text-white font-bold`,children:["Redirecting in ",s]})]})})})}export{o as default};
