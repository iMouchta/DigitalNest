import { Box, ListItem, ListItemText } from "@mui/material";

export default function NotificationDisplay({ notificationText, isUnread }) {
  return (
    <ListItem sx={{ minWidth: 200 }}>
      <ListItemText
        primary={notificationText}
        sx={{ maxWidth: 300, textAlign: 'justify' }}
      />
      {isUnread && <Box sx={{ bgcolor: "rgb(0, 123, 255)", width: 12, height: 12, borderRadius: '50%', marginLeft: 3}} />}
    </ListItem>
  );
}
